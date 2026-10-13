<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\User;

test('a vendor cannot view another vendors order', function () {
    $vendorA = User::factory()->create(['role' => User::ROLE_VENDOR, 'status' => User::STATUS_ACTIVE]);
    $vendorB = User::factory()->create(['role' => User::ROLE_VENDOR, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $category = AdminCategory::create(['name' => 'Authorization Test', 'slug' => 'authorization-test', 'status' => 'published']);
    $product = AdminProduct::create([
        'name' => 'Vendor B Product', 'sku' => 'VENDOR-B-PRODUCT', 'regular_price' => 10,
        'quantity' => 5, 'stock_status' => 'in_stock', 'category_id' => $category->id,
        'vendor_id' => $vendorB->id, 'status' => 'published',
    ]);
    $order = Order::create([
        'order_number' => 'ORD-AUTH-001', 'user_id' => $customer->id, 'vendor_id' => null,
        'subtotal' => 10, 'shipping_total' => 10, 'shipping_method' => 'standard',
        'payment_method' => 'cod', 'total' => 20, 'status' => 'pending',
        'shipping_name' => 'Customer', 'shipping_phone' => '03000000000',
        'shipping_address' => 'Test address', 'placed_at' => now(),
    ]);
    $order->items()->create(['product_id' => $product->id, 'product_name' => $product->name, 'quantity' => 1, 'unit_price' => 10, 'subtotal' => 10]);

    $this->actingAs($vendorA)->get(route('vendor.orders.details', $order->id))->assertNotFound();
});

test('a customer cannot view another customers order', function () {
    $customerA = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $customerB = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $order = Order::create([
        'order_number' => 'ORD-AUTH-002', 'user_id' => $customerB->id, 'vendor_id' => null,
        'subtotal' => 10, 'shipping_total' => 10, 'shipping_method' => 'standard',
        'payment_method' => 'cod', 'total' => 20, 'status' => 'pending',
        'shipping_name' => 'Customer', 'shipping_phone' => '03000000000',
        'shipping_address' => 'Test address', 'placed_at' => now(),
    ]);

    $this->actingAs($customerA)->get(route('user.details', $order->id))->assertNotFound();
});