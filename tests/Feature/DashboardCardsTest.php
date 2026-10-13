<?php

use App\Models\ActivityLog;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

test('admin dashboard renders all metric cards, tables, and quick tool links with accurate data', function () {
    $admin = User::factory()->create([
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $customer = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    $employee = User::factory()->create([
        'role' => 'employee',
        'email_verified_at' => now(),
        'status' => 'active',
    ]);

    $productLow = AdminProduct::create([
        'name' => 'Low Stock Gadget',
        'sku' => 'SKU-LOW-' . uniqid(),
        'regular_price' => 45.00,
        'quantity' => 3,
        'stock_status' => 'in_stock',
        'status' => 'published',
    ]);

    $order = Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-ADM-' . strtoupper(uniqid()),
        'subtotal' => 250.00,
        'total' => 250.00,
        'status' => 'completed',
        'payment_method' => 'cod',
        'shipping_name' => 'John Customer',
        'shipping_address' => 'Mall Road, Lahore',
    ]);

    ActivityLog::create([
        'actor_type' => User::class,
        'actor_id' => $admin->id,
        'actor_role' => 'admin',
        'action' => 'login',
        'description' => 'Admin logged into system',
    ]);

    $response = $this->actingAs($admin)
        ->get(route('admin.dashboard'));

    $response->assertOk()
        // Top 5 metric cards
        ->assertSee('Revenue')
        ->assertSee('$250.00')
        ->assertSee('Orders')
        ->assertSee('Employees')
        ->assertSee('Customers')
        ->assertSee('Products')
        // Employee Quick List
        ->assertSee($employee->name)
        // Recent Orders Table
        ->assertSee($order->order_number)
        ->assertSee('Details →')
        // Quick Tools Card
        ->assertSee('Employees Hub')
        ->assertSee('Create Excel Report')
        ->assertSee('Blacklisted PayPal')
        ->assertSee('Reservations')
        // Stock Alerts Card
        ->assertSee('Low Stock Alerts')
        ->assertSee('Low Stock Gadget')
        ->assertSee('3 left')
        // Recent Activity Card
        ->assertSee('Recent Activity')
        ->assertSee('Admin logged into system');
});

test('employee dashboard renders all 10 order pipeline cards and both overview cards with working routes', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
        'email_verified_at' => now(),
    ]);

    $customer = User::factory()->create([
        'role' => 'user',
        'email_verified_at' => now(),
    ]);

    // Create completed order
    $completedOrder = Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-EMP-COMP-' . strtoupper(uniqid()),
        'subtotal' => 120.00,
        'total' => 120.00,
        'status' => 'completed',
        'payment_method' => 'cod',
        'shipping_name' => 'Alice Customer',
        'shipping_address' => 'Gulberg, Lahore',
    ]);

    // Create on_hold order
    Order::create([
        'user_id' => $customer->id,
        'order_number' => 'ORD-EMP-HOLD-' . strtoupper(uniqid()),
        'subtotal' => 80.00,
        'total' => 80.00,
        'status' => 'on_hold',
        'payment_method' => 'cod',
        'shipping_name' => 'Bob Customer',
        'shipping_address' => 'DHA, Lahore',
    ]);

    $response = $this->actingAs($employee)
        ->get(route('employee.dashboard'));

    $response->assertOk()
        // Dashboard title
        ->assertSee('Orders Overview')
        // 10 Status Cards
        ->assertSee('Completed')
        ->assertSee('Total Orders')
        ->assertSee('Reviewed')
        ->assertSee('Commissioned')
        ->assertSee('On Hold')
        ->assertSee('Refunded')
        ->assertSee('Cancelled')
        ->assertSee('Refund Pending')
        ->assertSee('Review Submitted')
        ->assertSee('Review Deleted')
        // Overview Sections
        ->assertSee('Completed Orders')
        ->assertSee($completedOrder->order_number)
        ->assertSee('Order By Status');

    // Test that the card destination routes are all reachable by employee
    $cardRoutes = [
        'completed',
        'ordered',
        'reviewed',
        'commissioned',
        'on-hold',
        'refunded',
        'cancelled',
        'refunded-pending-review',
        'review-submitted-refund',
        'review-deleted',
    ];

    foreach ($cardRoutes as $status) {
        $this->actingAs($employee)
            ->get(route('employee.orders', $status))
            ->assertOk();
    }
});
