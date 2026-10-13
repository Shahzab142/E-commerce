<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Reservation;
use App\Models\User;

test('admin can view the add product page and successfully add a product', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $category = AdminCategory::create([
        'name' => 'Laptops',
        'slug' => 'laptops-' . uniqid(),
        'status' => 'published',
    ]);

    // 1. Admin can access add product page
    $this->actingAs($admin)
        ->get(route('admin.products.add'))
        ->assertOk()
        ->assertSee('Add Product');

    // 2. Admin can create product
    $sku = 'SKU-' . strtoupper(uniqid());
    $response = $this->actingAs($admin)
        ->post(route('admin.products.create'), [
            'name' => 'Dell XPS 15 Test Laptop',
            'sku' => $sku,
            'regular_price' => 1499.99,
            'sale_price' => 1399.99,
            'quantity' => 25,
            'stock_status' => 'in_stock',
            'category_id' => $category->id,
            'status' => 'published',
            'short_description' => 'A powerful laptop',
            'description' => 'Detailed laptop description',
        ]);

    $response->assertRedirect(route('admin.products.add'));
    $response->assertSessionHas('success', 'Product added successfully.');
    expect(AdminProduct::where('sku', $sku)->exists())->toBeTrue();

    // 3. Admin can view the product in view-product list
    $this->actingAs($admin)
        ->get(route('admin.products.view'))
        ->assertOk()
        ->assertSee('Dell XPS 15 Test Laptop');

    // 4. Admin can export / download products excel
    $exportResponse = $this->actingAs($admin)
        ->get(route('admin.products.export'));
    $exportResponse->assertOk();
});

test('employee cannot access admin product creation routes and is prevented', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
        'email_verified_at' => now(),
    ]);

    $category = AdminCategory::create([
        'name' => 'Mobile Phones',
        'slug' => 'phones-' . uniqid(),
        'status' => 'published',
    ]);

    // 1. Employee cannot view admin add-product page (redirected away from Admin area)
    $this->actingAs($employee)
        ->get(route('admin.products.add'))
        ->assertRedirect(route('employee.dashboard'))
        ->assertSessionHas('error');

    // 2. Employee cannot submit product to admin create-product route
    $this->actingAs($employee)
        ->post(route('admin.products.create'), [
            'name' => 'Hacker Product',
            'sku' => 'SKU-FORBIDDEN-001',
            'regular_price' => 100,
            'quantity' => 10,
            'stock_status' => 'in_stock',
            'category_id' => $category->id,
            'status' => 'published',
        ])
        ->assertRedirect(route('employee.dashboard'))
        ->assertSessionHas('error');

    // Product must not be created
    expect(AdminProduct::where('sku', 'SKU-FORBIDDEN-001')->exists())->toBeFalse();
});

test('employee can only view products, reserve products, and download excel', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
        'email_verified_at' => now(),
    ]);

    $category = AdminCategory::create([
        'name' => 'Accessories',
        'slug' => 'accessories-' . uniqid(),
        'status' => 'published',
    ]);

    $product = AdminProduct::create([
        'name' => 'Wireless Gaming Mouse',
        'sku' => 'SKU-MOUSE-' . uniqid(),
        'regular_price' => 59.99,
        'quantity' => 15,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'status' => 'published',
    ]);

    // Create an order for the excel export test
    $order = Order::create([
        'user_id' => $employee->id,
        'order_number' => 'ORD-' . strtoupper(uniqid()),
        'subtotal' => 59.99,
        'total' => 59.99,
        'status' => 'ordered',
        'payment_method' => 'cod',
        'shipping_name' => 'Test User',
        'shipping_address' => '123 Street',
    ]);
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'product_name' => $product->name,
        'unit_price' => 59.99,
        'quantity' => 1,
        'subtotal' => 59.99,
    ]);

    // 1. Employee can view products list
    $this->actingAs($employee)
        ->get(route('employee.products', 'all'))
        ->assertOk()
        ->assertSee('Active Products')
        ->assertSee('Reserve Now')
        // Employee product screen does NOT contain "Add Product" button
        ->assertDontSee('Add Product');

    // 2. Employee can reserve product
    $reserveResponse = $this->actingAs($employee)
        ->post(route('employee.reservations.store'), [
            'product_id' => $product->id,
        ]);

    $reserveResponse->assertRedirect();
    expect(Reservation::where('user_id', $employee->id)->where('product_id', $product->id)->exists())->toBeTrue();

    // 3. Employee can view active reservations
    $this->actingAs($employee)
        ->get(route('employee.reservations.index'))
        ->assertOk()
        ->assertSee('Reservations');

    // 4. Employee can access excel create/download page
    $this->actingAs($employee)
        ->get(route('employee.excel.create'))
        ->assertOk()
        ->assertSee('Create Excel');

    // 5. Employee can generate and download excel
    $downloadResponse = $this->actingAs($employee)
        ->post(route('employee.excel.generate'), [
            'from_date' => now()->subDays(7)->toDateString(),
            'to_date' => now()->addDay()->toDateString(),
            'order_status' => '',
        ]);
    $downloadResponse->assertOk();
});
