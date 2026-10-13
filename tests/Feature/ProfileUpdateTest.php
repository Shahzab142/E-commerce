<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('an admin can update their personal and business profile', function () {
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE, 'name' => 'Old Name']);

    $response = $this->actingAs($admin)->patch(route('admin.profile.update'), [
        'name' => 'New Admin Name',
        'email' => $admin->email,
        'phone' => '03001112222',
        'city' => 'Karachi',
    ]);

    $response->assertRedirect(route('admin.profile'));
    expect($admin->refresh()->name)->toBe('New Admin Name')
        ->and($admin->phone)->toBe('03001112222')
        ->and($admin->adminDetail->city)->toBe('Karachi');
});

test('an admin can change their password by providing the current one', function () {
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE, 'password' => Hash::make('old-password')]);

    $response = $this->actingAs($admin)->patch(route('admin.profile.update'), [
        'name' => $admin->name,
        'email' => $admin->email,
        'current_password' => 'old-password',
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ])->assertRedirect(route('admin.profile'));

    expect(Hash::check('brand-new-password', $admin->refresh()->password))->toBeTrue();
});

test('an admin cannot change their password without the correct current password', function () {
    $admin = User::factory()->create(['role' => User::ROLE_ADMIN, 'status' => User::STATUS_ACTIVE, 'password' => Hash::make('old-password')]);

    $this->actingAs($admin)->patch(route('admin.profile.update'), [
        'name' => $admin->name,
        'email' => $admin->email,
        'current_password' => 'wrong-password',
        'password' => 'brand-new-password',
        'password_confirmation' => 'brand-new-password',
    ])->assertSessionHasErrors('current_password');

    expect(Hash::check('old-password', $admin->refresh()->password))->toBeTrue();
});

test('an employee can view and update their profile', function () {
    $employee = User::factory()->create(['role' => User::ROLE_EMPLOYEE, 'status' => User::STATUS_ACTIVE]);

    $response = $this->actingAs($employee)->post(route('employee.profile.update'), [
        'name' => 'Updated Employee',
        'phone' => '03001234567',
        'city' => 'Islamabad',
    ]);

    $response->assertRedirect();
    expect($employee->fresh()->name)->toBe('Updated Employee');
});

test('a customer can update their address details', function () {
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);

    $response = $this->actingAs($customer)->patch(route('user.settings.update'), [
        'name' => $customer->name,
        'email' => $customer->email,
        'phone' => '03007778888',
        'city' => 'Lahore',
        'address' => '456 Residential Road',
    ]);

    $response->assertRedirect(route('user.settings'));
    $customer->load('userDetail');
    expect($customer->fresh()->phone)->toBe('03007778888')
        ->and($customer->userDetail->city)->toBe('Lahore')
        ->and($customer->userDetail->address)->toBe('456 Residential Road');
});

test('a user cannot take over another users email when updating settings', function () {
    $existing = User::factory()->create(['email' => 'taken@example.com']);
    $customer = User::factory()->create(['role' => User::ROLE_USER, 'status' => User::STATUS_ACTIVE]);

    $this->actingAs($customer)->patch(route('user.settings.update'), [
        'name' => $customer->name,
        'email' => 'taken@example.com',
    ])->assertSessionHasErrors('email');
});
