<?php

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;

function checkoutProduct(int $quantity = 5): AdminProduct
{
    $vendor = User::factory()->create(['role' => User::ROLE_VENDOR, 'status' => User::STATUS_ACTIVE]);
    $category = AdminCategory::create(['name' => 'Coupon Test Category', 'slug' => 'coupon-test-'.uniqid(), 'status' => 'published']);

    return AdminProduct::create([
        'name' => 'Coupon Test Product',
        'sku' => 'CPN-'.uniqid(),
        'regular_price' => 100,
        'quantity' => $quantity,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'status' => 'published',
    ]);
}

test('a valid coupon can be applied to the cart and reduces the total', function () {
    $product = checkoutProduct();
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    Coupon::create(['code' => 'SAVE10', 'type' => 'fixed', 'value' => 10, 'is_active' => true]);

    $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 2], 'coupon_code' => 'SAVE10'])
        ->post(route('cart.coupon.apply', 'products'), ['code' => 'save10'])
        ->assertRedirect();

    $response = $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 2], 'coupon_code' => 'SAVE10'])
        ->get(route('cart.list', 'products'));

    $response->assertSee('SAVE10');
    $response->assertViewHas('discount', 10.0);
    $response->assertViewHas('total', 190.0);
});

test('an invalid coupon code is rejected', function () {
    $product = checkoutProduct();
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);

    $response = $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 1]])
        ->post(route('cart.coupon.apply', 'products'), ['code' => 'DOESNOTEXIST']);

    $response->assertRedirect();
    $response->assertSessionHas('warning');
    expect(session('coupon_code'))->toBeNull();
});

test('an expired coupon cannot be applied', function () {
    $product = checkoutProduct();
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    Coupon::create(['code' => 'EXPIRED', 'type' => 'fixed', 'value' => 10, 'is_active' => true, 'expires_at' => now()->subDay()]);

    $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 1]])
        ->post(route('cart.coupon.apply', 'products'), ['code' => 'EXPIRED'])
        ->assertSessionHas('warning');
});

test('a percent coupon respects the max discount cap', function () {
    $coupon = Coupon::create([
        'code' => 'BIG50',
        'type' => 'percent',
        'value' => 50,
        'max_discount_amount' => 30,
        'is_active' => true,
    ]);

    // 50% of 200 would be 100, but capped at 30.
    expect($coupon->discountFor(200))->toBe(30.0);
});

test('a coupon below the minimum order amount does not apply', function () {
    $coupon = Coupon::create([
        'code' => 'MIN100',
        'type' => 'fixed',
        'value' => 20,
        'min_order_amount' => 100,
        'is_active' => true,
    ]);

    expect($coupon->discountFor(50))->toBe(0.0);
});

test('placing an order with an applied coupon records the discount and increments usage', function () {
    $product = checkoutProduct();
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $coupon = Coupon::create(['code' => 'ORDER10', 'type' => 'fixed', 'value' => 10, 'is_active' => true]);

    $response = $this->actingAs($customer)
        ->withSession(['cart' => [$product->id => 1], 'coupon_code' => 'ORDER10'])
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

    $order = Order::query()->firstOrFail();
    expect((float) $order->discount_total)->toBe(10.0)
        ->and($order->coupon_code)->toBe('ORDER10')
        ->and((float) $order->total)->toBe(100.0) // 100 subtotal - 10 discount + 10 standard shipping
        ->and($coupon->refresh()->times_used)->toBe(1);
});
