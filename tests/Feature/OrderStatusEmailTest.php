<?php

use App\Mail\OrderDeliveredEmail;
use App\Mail\OrderShippedEmail;
use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

/**
 * Create a customer order with one item (mirrors the pattern used in
 * OrderAuthorizationTest so no Order factory is required).
 */
function makeStatusTestOrder(User $customer, string $status = 'processing'): Order
{
    $category = AdminCategory::create([
        'name' => 'Status Test',
        'slug' => 'status-test-'.uniqid(),
        'status' => 'published',
    ]);
    $product = AdminProduct::create([
        'name' => 'Status Test Product',
        'sku' => 'STATUS-TEST-'.uniqid(),
        'regular_price' => 25,
        'quantity' => 10,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'status' => 'published',
    ]);
    $order = Order::create([
        'order_number' => 'ORD-STATUS-'.uniqid(),
        'user_id' => $customer->id,
        'vendor_id' => null,
        'subtotal' => 25,
        'shipping_total' => 5,
        'shipping_method' => 'standard',
        'payment_method' => 'cod',
        'total' => 30,
        'status' => $status,
        'shipping_name' => 'Status Customer',
        'shipping_phone' => '03000000000',
        'shipping_address' => 'Test address',
        'placed_at' => now(),
    ]);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'quantity' => 1,
        'unit_price' => 25,
        'subtotal' => 25,
    ]);

    return $order;
}

test('customer receives shipped email when admin ships their order', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $order = makeStatusTestOrder($customer);

    $this->actingAs($admin)
        ->patch(route('admin.orders.status', $order->id), ['status' => 'shipped'])
        ->assertRedirect(route('admin.orders.index'));

    Mail::assertSent(OrderShippedEmail::class, function (OrderShippedEmail $mail) use ($order, $customer) {
        return $mail->hasTo($customer->email)
            && $mail->order->id === $order->id;
    });
    Mail::assertNotSent(OrderDeliveredEmail::class);
});

test('customer receives delivered email when admin delivers their order', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $order = makeStatusTestOrder($customer);

    $this->actingAs($admin)
        ->patch(route('admin.orders.status', $order->id), ['status' => 'delivered'])
        ->assertRedirect(route('admin.orders.index'));

    Mail::assertSent(OrderDeliveredEmail::class, function (OrderDeliveredEmail $mail) use ($order, $customer) {
        return $mail->hasTo($customer->email)
            && $mail->order->id === $order->id;
    });
    Mail::assertNotSent(OrderShippedEmail::class);
});

test('no status email is sent for other status transitions', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $order = makeStatusTestOrder($customer);

    $this->actingAs($admin)
        ->patch(route('admin.orders.status', $order->id), ['status' => 'processing'])
        ->assertRedirect(route('admin.orders.index'));

    Mail::assertNothingSent();
});

test('customer receives shipped email when vendor ships their order', function () {
    Mail::fake();

    $vendor = User::factory()->create(['role' => User::ROLE_VENDOR, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);

    // The vendor authorization scope resolves orders through
    // items.product.vendor_id, so the product must belong to the vendor.
    $category = AdminCategory::create([
        'name' => 'Status Test',
        'slug' => 'status-test-'.uniqid(),
        'status' => 'published',
    ]);
    $product = AdminProduct::create([
        'name' => 'Status Test Product',
        'sku' => 'STATUS-TEST-'.uniqid(),
        'regular_price' => 25,
        'quantity' => 10,
        'stock_status' => 'in_stock',
        'category_id' => $category->id,
        'vendor_id' => $vendor->id,
        'status' => 'published',
    ]);
    $order = Order::create([
        'order_number' => 'ORD-STATUS-'.uniqid(),
        'user_id' => $customer->id,
        'vendor_id' => $vendor->id,
        'subtotal' => 25,
        'shipping_total' => 5,
        'shipping_method' => 'standard',
        'payment_method' => 'cod',
        'total' => 30,
        'status' => 'processing',
        'shipping_name' => 'Status Customer',
        'shipping_phone' => '03000000000',
        'shipping_address' => 'Test address',
        'placed_at' => now(),
    ]);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'quantity' => 1,
        'unit_price' => 25,
        'subtotal' => 25,
    ]);

    $this->actingAs($vendor)
        ->patch(route('vendor.orders.status', $order->id), ['status' => 'shipped'])
        ->assertRedirect(route('vendor.orders.index'));

    Mail::assertSent(OrderShippedEmail::class, function (OrderShippedEmail $mail) use ($customer, $order) {
        return $mail->hasTo($customer->email)
            && $mail->order->id === $order->id;
    });
    Mail::assertNotSent(OrderDeliveredEmail::class);
});

test('order status persists after admin update', function () {
    Mail::fake();

    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE]);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);
    $order = makeStatusTestOrder($customer);

    $this->actingAs($admin)
        ->patch(route('admin.orders.status', $order->id), ['status' => 'shipped']);

    expect($order->fresh()->status)->toBe('shipped');
});