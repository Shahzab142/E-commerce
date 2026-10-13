<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\UserPaymentMethod;
use App\Models\WishlistItem;

test('wishlist page renders for a customer', function () {
    $user = User::factory()->create(['role' => 'user']);
    $this->actingAs($user);

    $this->get(route('user.wishlist'))
        ->assertOk()
        ->assertSee('My Wishlist');
});

test('customer can add a product to their wishlist', function () {
    $user = User::factory()->create(['role' => 'user']);
    $product = AdminProduct::create([
        'name' => 'Test Product',
        'sku' => 'SKU-TEST-001',
        'regular_price' => 100.00,
        'quantity' => 10,
        'stock_status' => 'in_stock',
        'status' => 'published',
    ]);

    $this->actingAs($user)
        ->post(route('wishlist.toggle', $product))
        ->assertRedirect();

    expect(WishlistItem::where('user_id', $user->id)->count())->toBe(1);
});

test('customer can remove a product from their wishlist', function () {
    $user = User::factory()->create(['role' => 'user']);
    $product = AdminProduct::create([
        'name' => 'Test Product',
        'sku' => 'SKU-TEST-002',
        'regular_price' => 100.00,
        'quantity' => 10,
        'stock_status' => 'in_stock',
        'status' => 'published',
    ]);
    WishlistItem::create(['user_id' => $user->id, 'product_id' => $product->id]);

    $this->actingAs($user)
        ->post(route('wishlist.toggle', $product))
        ->assertRedirect();

    expect(WishlistItem::where('user_id', $user->id)->count())->toBe(0);
});

test('settings page shows saved payment methods', function () {
    $user = User::factory()->create(['role' => 'user']);
    UserPaymentMethod::create([
        'user_id' => $user->id,
        'type' => 'easypaisa',
        'account_title' => 'John Doe',
        'account_number' => '03001234567',
    ]);

    $this->actingAs($user)
        ->get(route('user.settings'))
        ->assertOk()
        ->assertSee('Saved Payment Methods');
});

test('customer can save a payment method', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->post(route('user.settings.payment-methods.store'), [
            'type' => 'bank',
            'account_title' => 'Jane Doe',
            'account_number' => '1234567890',
            'bank_name' => 'HBL',
        ])
        ->assertRedirect();

    expect(UserPaymentMethod::where('user_id', $user->id)->count())->toBe(1);
});

test('settings page shows saved shipping addresses', function () {
    $user = User::factory()->create(['role' => 'user']);
    ShippingAddress::create([
        'user_id' => $user->id,
        'label' => 'Home',
        'full_name' => 'John Doe',
        'address' => '123 Main St',
        'city' => 'Lahore',
        'country' => 'Pakistan',
    ]);

    $this->actingAs($user)
        ->get(route('user.settings'))
        ->assertOk()
        ->assertSee('Saved Shipping Addresses');
});

test('customer can save a shipping address', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->post(route('user.settings.shipping-addresses.store'), [
            'label' => 'Work',
            'full_name' => 'John Doe',
            'phone' => '+923001234567',
            'address' => '456 Office Road',
            'city' => 'Karachi',
            'state' => 'Sindh',
            'postal_code' => '74000',
            'country' => 'Pakistan',
        ])
        ->assertRedirect();

    expect(ShippingAddress::where('user_id', $user->id)->count())->toBe(1);
});

test('customer can set a default shipping address', function () {
    $user = User::factory()->create(['role' => 'user']);
    $first = ShippingAddress::create([
        'user_id' => $user->id,
        'label' => 'Home',
        'full_name' => 'John Doe',
        'address' => '123 Main St',
    ]);
    $second = ShippingAddress::create([
        'user_id' => $user->id,
        'label' => 'Work',
        'full_name' => 'John Doe',
        'address' => '456 Office Rd',
    ]);

    $this->actingAs($user)
        ->post(route('user.settings.shipping-addresses.default', $second))
        ->assertRedirect();

    expect($first->refresh()->is_default)->toBeFalsy();
    expect($second->refresh()->is_default)->toBeTruthy();
});

test('customer can delete a shipping address', function () {
    $user = User::factory()->create(['role' => 'user']);
    $address = ShippingAddress::create([
        'user_id' => $user->id,
        'label' => 'Home',
        'full_name' => 'John Doe',
        'address' => '123 Main St',
    ]);

    $this->actingAs($user)
        ->delete(route('user.settings.shipping-addresses.delete', $address))
        ->assertRedirect();

    expect($address->fresh()->trashed())->toBeTrue();
});
test('product detail page renders for guests and shows wishlist button', function () {
    $category = AdminCategory::create(['name' => 'Test', 'slug' => 'test', 'status' => 'published']);
    $product = AdminProduct::create([
        'name' => 'Wishlist Product',
        'sku' => 'SKU-WISH-001',
        'regular_price' => 50.00,
        'quantity' => 5,
        'stock_status' => 'in_stock',
        'status' => 'published',
        'category_id' => $category->id,
    ]);

    $this->get(route('product.detail', $product->id))
        ->assertOk()
        ->assertSee('Add to Wishlist');
});

test('product detail page shows wishlist state for authenticated user', function () {
    $category = AdminCategory::create(['name' => 'Test', 'slug' => 'test', 'status' => 'published']);
    $product = AdminProduct::create([
        'name' => 'Wishlist Product',
        'sku' => 'SKU-WISH-002',
        'regular_price' => 50.00,
        'quantity' => 5,
        'stock_status' => 'in_stock',
        'status' => 'published',
        'category_id' => $category->id,
    ]);
    $user = User::factory()->create(['role' => 'user']);
    $user->wishlistItems()->create(['product_id' => $product->id]);

    $this->actingAs($user)
        ->get(route('product.detail', $product->id))
        ->assertOk()
        ->assertSee('Remove from Wishlist');
});

test('home page renders with wishlist support for customers', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->get(route('home'))
        ->assertOk();
});

test('shop page renders with wishlist support for customers', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->get(route('shop'))
        ->assertOk();
});