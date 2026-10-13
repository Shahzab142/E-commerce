<?php

use App\Livewire\Admin\Authentication\Signup as AdminSignup;
use App\Livewire\Vendor\Authentication\Signup as VendorSignup;
use App\Models\User;
use Livewire\Livewire;
use Livewire\Volt\Volt;

describe('User Registration via Service', function () {
    test('user registration service creates user with role', function () {
        (new \App\Services\UserRegistrationService())->register(
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+1234567890', 'password' => 'Password123!'],
            [],
            'user'
        );

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'role' => 'user',
        ]);
    });

    test('user registration status is pending', function () {
        $user = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Jane Doe', 'email' => 'jane@example.com', 'password' => 'Password123!'],
            [],
            'user'
        );

        $this->assertEquals('pending', $user->status);
        $this->assertEquals('user', $user->role);
    });

    test('user helper methods work', function () {
        $user = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Test User', 'email' => 'test@example.com', 'password' => 'Password123!'],
            [],
            'user'
        );

        $this->assertFalse($user->isVendor());
        $this->assertFalse($user->isAdmin());
    });
});

describe('Vendor Registration via Service', function () {
    test('vendor signup page renders a submit form for registration', function () {
        $html = Livewire::test(VendorSignup::class)->html();

        expect($html)
            ->toContain('wire:submit.prevent="register"')
            ->and($html)->toContain('type="submit"');
    });

    test('vendor can register with valid data', function () {
        $userData = [
            'name' => 'Vendor Shop',
            'email' => 'vendor@example.com',
            'phone' => '+1234567890',
            'password' => 'Password123!',
            'business_name' => 'ABC Trading',
            'business_type' => 'Electronics',
            'business_phone' => '+1987654321',
            'business_address' => '123 Business Street',
        ];

        $vendor = (new \App\Services\UserRegistrationService())->register(
            array_filter($userData, function ($key) {
                return in_array($key, ['name', 'email', 'phone', 'password']);
            }, ARRAY_FILTER_USE_KEY),
            array_filter($userData, function ($key) {
                return in_array($key, ['business_name', 'business_type', 'business_phone', 'business_address']);
            }, ARRAY_FILTER_USE_KEY),
            'vendor',
            'vendorDetail'
        );

        $this->assertDatabaseHas('users', [
            'email' => 'vendor@example.com',
            'role' => 'vendor',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('vendor_details', [
            'user_id' => $vendor->id,
            'business_name' => 'ABC Trading',
        ]);
    });

    test('vendor registration creates user with vendor role', function () {
        (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Shop', 'email' => 'shop@example.com', 'password' => 'Password123!'],
            ['business_name' => 'Store', 'business_phone' => '+1234567890', 'business_address' => 'Street'],
            'vendor',
            'vendorDetail'
        );

        $user = User::where('email', 'shop@example.com')->first();
        $this->assertTrue($user->isVendor());
    });

    test('vendor status is pending on registration', function () {
        $vendor = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Vendor', 'email' => 'vendor@example.com', 'password' => 'Password123!'],
            ['business_name' => 'Store', 'business_phone' => '+1234567890', 'business_address' => 'Street'],
            'vendor',
            'vendorDetail'
        );

        $this->assertEquals('pending', $vendor->status);
    });

    test('vendor detail relationship works', function () {
        $vendor = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Shop Owner', 'email' => 'owner@example.com', 'password' => 'Password123!'],
            ['business_name' => 'Premium Store', 'business_phone' => '+1987654321', 'business_address' => 'Main Street'],
            'vendor',
            'vendorDetail'
        );

        $this->assertNotNull($vendor->vendorDetail);
        $this->assertEquals('Premium Store', $vendor->vendorDetail->business_name);
    });

    test('vendor signup redirects to the vendor dashboard', function () {
        Livewire::test(VendorSignup::class)
            ->set('name', 'Vendor User')
            ->set('email', 'vendor-pending@example.com')
            ->set('phone', '+1234567890')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('business_name', 'Pending Store')
            ->set('business_type', 'Online Retail')
            ->set('business_phone', '+1234567890')
            ->set('registration_number', '12345-6789012-3')
            ->set('business_address', '123 Main Street')
            ->set('account_title', 'Vendor User')
            ->set('bank_name', 'Test Bank')
            ->set('account_number', '12345678')
            ->set('iban', 'PK00TEST1234567890123456')
            ->set('acceptTerms', true)
            ->call('register')
            ->assertRedirect(route('verification.verify-code', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'vendor-pending@example.com',
            'role' => 'vendor',
            'status' => 'pending',
        ]);
    });
});

describe('User Registration via Auth Component', function () {
    test('user registration redirects to the user dashboard', function () {
        Volt::test('auth.register')
            ->set('name', 'New Customer')
            ->set('email', 'new-customer@example.com')
            ->set('phone', '+1234567890')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->call('register')
            ->assertRedirect(route('verification.verify-code', absolute: false));
    });
});

describe('Admin Registration via Service', function () {
    test('authenticated admin can access the admin dashboard', function () {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $this->actingAs($admin)
            ->get('/admin')
            ->assertOk();
    });

    test('admin signup validation fails when required fields are missing', function () {
        Livewire::test(AdminSignup::class)
            ->call('register')
            ->assertHasErrors([
                'name',
                'email',
                'password',
                'password_confirmation',
                'country',
                'state',
                'city',
                'postal_code',
                'address',
            ]);
    });

    test('admin signup creates a user and redirects to the admin dashboard', function () {
        Livewire::test(AdminSignup::class)
            ->set('name', 'Admin Signup User')
            ->set('email', 'admin-signup@example.com')
            ->set('phone', '+1234567890')
            ->set('country', 'Pakistan')
            ->set('state', 'Punjab')
            ->set('city', 'Lahore')
            ->set('postal_code', '54000')
            ->set('address', '123 Admin Street')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->call('register')
            ->assertRedirect(route('verification.verify-code', absolute: false));

        $this->assertDatabaseHas('users', [
            'email' => 'admin-signup@example.com',
            'role' => 'admin',
            'status' => 'active',
        ]);
    });

    test('admin can register as first admin user', function () {
        $admin = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Admin User', 'email' => 'admin@example.com', 'phone' => '+1234567890', 'password' => 'Password123!'],
            ['country' => 'United States', 'state' => 'California', 'city' => 'Los Angeles', 'postal_code' => '90001', 'address' => '123 Admin Street'],
            'admin',
            'adminDetail'
        );

        $this->assertDatabaseHas('users', [
            'email' => 'admin@example.com',
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('admin_details', [
            'user_id' => $admin->id,
            'country' => 'United States',
            'city' => 'Los Angeles',
        ]);
    });

    test('admin registration creates both user and admin details', function () {
        $admin = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Administrator', 'email' => 'admin@example.com', 'password' => 'Password123!'],
            ['country' => 'USA', 'city' => 'NYC'],
            'admin',
            'adminDetail'
        );

        $user = User::where('email', 'admin@example.com')->first();
        $this->assertTrue($user->isAdmin());
        $this->assertNotNull($user->adminDetail);
        $this->assertEquals('USA', $user->adminDetail->country);
    });

    test('admin status is active on registration', function () {
        $admin = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => 'Password123!'],
            [],
            'admin',
            'adminDetail'
        );

        $this->assertEquals('active', $admin->status);
    });

    test('admin detail relationship works', function () {
        $admin = (new \App\Services\UserRegistrationService())->register(
            ['name' => 'Super Admin', 'email' => 'superadmin@example.com', 'password' => 'Password123!'],
            ['country' => 'England', 'city' => 'London'],
            'admin',
            'adminDetail'
        );

        $this->assertNotNull($admin->adminDetail);
        $this->assertEquals('England', $admin->adminDetail->country);
    });
});

describe('Role-Based Access Control', function () {
    test('admin login redirects to admin dashboard', function () {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active', 'login_verified_at' => now()]);

        Volt::test('auth.login')
            ->set('email', $admin->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('admin.dashboard', absolute: false));
    });

    test('vendor login redirects to vendor dashboard', function () {
        $vendor = User::factory()->create(['role' => 'vendor', 'status' => 'active', 'login_verified_at' => now()]);

        Volt::test('auth.login')
            ->set('email', $vendor->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('vendor.dashboard', absolute: false));
    });

    test('customer login redirects to user dashboard', function () {
        $customer = User::factory()->create(['role' => 'user', 'status' => 'active']);

        Volt::test('auth.login')
            ->set('email', $customer->email)
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(route('home', absolute: false));
    });

    test('user can access user dashboard', function () {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/user');

        $response->assertSuccessful();
    });

    test('vendor cannot access admin dashboard', function () {
        $vendor = User::factory()->create(['role' => 'vendor']);

        $response = $this->actingAs($vendor)->get('/admin');

        $response->assertForbidden();
    });

    test('admin can access admin dashboard', function () {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertSuccessful();
    });

    test('vendor can access vendor dashboard', function () {
        $vendor = User::factory()->create(['role' => 'vendor']);

        $response = $this->actingAs($vendor)->get('/vendor');

        $response->assertSuccessful();
    });

    test('vendor dashboard includes bootstrap css', function () {
        $vendor = User::factory()->create(['role' => 'vendor', 'status' => 'active']);

        $response = $this->actingAs($vendor)->get('/vendor');

        $response->assertSee('https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', false);
    });

    test('user cannot access vendor dashboard', function () {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/vendor');

        $response->assertForbidden();
    });

    test('user cannot access admin dashboard', function () {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertForbidden();
    });

    test('unauthenticated user redirected to login from user dashboard', function () {
        $response = $this->get('/user');

        $response->assertRedirect('/login');
    });

    test('unauthenticated user redirected to login from admin', function () {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    });

    test('unauthenticated user redirected to login from vendor', function () {
        $response = $this->get('/vendor');

        $response->assertRedirect('/login');
    });
});




