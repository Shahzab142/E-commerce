<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\User;

test('a customer can place an order from the session cart', function () {
    $customer = User::factory()->create([
        'role' => User::ROLE_USER,
        'status' => User::STATUS_ACTIVE,
    ]);
    $vendor = User::factory()->create([
        'role' => User::ROLE_VENDOR,
        'status' => User::STATUS_ACTIVE,
    ]);
    $category = AdminCategory::create([
        'name' => 'Test Electronics',
        'slug' => 'test-electronics',
        'status' => 'published',
    ]);
    $product = AdminProduct::create([
        'name' => 'Test Headphones',
        'sku' => 'TEST-HEADPHONES',
        'regular_price' => 100,
        'quantity' => 3,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'status' => 'published',
    ]);

    $response = $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 2]])
        ->post(route('checkout.place', 'products'), [
            'name' => 'Test Customer',
            'email' => $customer->email,
            'phone' => '03001234567',
            'city' => 'Lahore',
            'address' => '1 Test Street',
            'shipping' => 'standard',
            'payment_method' => 'cod',
        ]);

    $response->assertRedirect(route('user.orders.history'));
    $order = Order::query()->with('items')->latest()->firstOrFail();

    expect($order->user_id)->toBe($customer->id)
        ->and((float) $order->total)->toBe(210.0)
        ->and($order->items)->toHaveCount(1)
        ->and($product->refresh()->quantity)->toBe(1)
        ->and(session('cart'))->toBeNull();
});

test('checkout validates required fields', function () {
    $this->post(route('checkout.place', 'products'), [])
        ->assertSessionHasErrors(['name', 'email', 'phone', 'city', 'address', 'shipping', 'payment_method']);
});