<?php

use App\Models\User;
use App\Models\AdminCategory;
use App\Models\AdminDetail;
use App\Models\AdminProduct;
use Illuminate\Support\Facades\Storage;

test('admin product delete route is generated without a duplicated admin prefix', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);

    $this->actingAs($admin);

    expect(route('admin.products.delete', ['id' => 99], false))
        ->toBe('/admin/delete-product/99');
});

test('admin dashboard and management pages render for the admin role', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();

    $this->actingAs($admin)
        ->get('/admin/vendors')
        ->assertOk();

    $this->actingAs($admin)
        ->get('/admin/users')
        ->assertOk();
});

test('admin can update vendor and customer statuses through role-scoped endpoints', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);
    $vendor = User::factory()->create(['role' => User::ROLE_VENDOR]);
    $customer = User::factory()->create(['role' => User::ROLE_USER]);

    $this->actingAs($admin)
        ->patch(route('admin.vendors.status', $vendor), ['status' => 'active'])
        ->assertRedirect(route('admin.vendors.index'));

    $this->actingAs($admin)
        ->patch(route('admin.users.status', $customer), ['status' => 'suspend'])
        ->assertRedirect(route('admin.users.index'));

    expect($vendor->refresh()->status)->toBe('active')
        ->and($customer->refresh()->status)->toBe('suspend');
});

test('admin status endpoints reject users with the wrong role', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);
    $customer = User::factory()->create(['role' => User::ROLE_USER]);

    $this->actingAs($admin)
        ->patch(route('admin.vendors.status', $customer), ['status' => 'active'])
        ->assertNotFound();
});

test('category list displays the dynamic product count and product vendor links to details', function () {
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);
    $vendor = User::factory()->create(['role' => User::ROLE_VENDOR]);
    $category = AdminCategory::create([
        'name' => 'Shoes',
        'slug' => 'shoes',
        'status' => 'published',
    ]);
    $product = AdminProduct::create([
        'name' => 'Running Shoes',
        'sku' => 'SHOE-001',
        'regular_price' => 50,
        'quantity' => 4,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'vendor_id' => $vendor->id,
        'status' => 'published',
    ]);

    $this->actingAs($admin)
        ->get(route('admin.categories.view'))
        ->assertSee('1');

    $this->actingAs($admin)
        ->get(route('admin.products.view'))
        ->assertSee(route('admin.vendors.show', ['user' => $vendor->id]), false);

    $this->actingAs($admin)
        ->get(route('admin.vendors.show', ['user' => $vendor->id]))
        ->assertOk()
        ->assertSee($vendor->name);

    expect($product->vendor->isVendor())->toBeTrue();
});

test('admin profile form includes persisted avatar and business logo fields', function () {
    Storage::fake('public');
    $admin = User::factory()->create([
        'role' => User::ROLE_ADMIN,
        'status' => User::STATUS_ACTIVE,
    ]);
    AdminDetail::create([
        'user_id' => $admin->id,
        'image' => 'admins/avatar.jpg',
        'logo' => 'admin-logos/logo.jpg',
    ]);

    Storage::disk('public')->put('admins/avatar.jpg', 'avatar');
    Storage::disk('public')->put('admin-logos/logo.jpg', 'logo');

    $this->actingAs($admin)
        ->get(route('admin.profile'))
        ->assertSee('name="image"', false)
        ->assertSee('name="logo"', false)
        ->assertSee(Storage::disk('public')->url('admins/avatar.jpg'), false)
        ->assertSee(Storage::disk('public')->url('admin-logos/logo.jpg'), false);
});

test('public responses include security headers and a sitemap is available', function () {
    $this->get('/')
        ->assertHeader('X-Content-Type-Options', 'nosniff')
        ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
        ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml')
        ->assertSee('<urlset', false);
});
