<?php

namespace Tests\Feature;

use App\Models\AdminCategory;
use App\Models\AdminDetail;
use App\Models\AdminProduct;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductQuestion;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\ShippingAddress;
use App\Models\User;
use App\Models\UserMessage;
use App\Models\UserPaymentMethod;
use App\Models\WishlistItem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FullSystemIntegrationTest extends TestCase
{
    protected User $admin;
    protected User $employee;
    protected User $customer;
    protected AdminCategory $category;
    protected AdminProduct $product;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // Setup Admin
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@khyberpro.com'],
            [
                'name' => 'System Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_ADMIN,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );
        $this->admin->update([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
        ]);

        AdminDetail::firstOrCreate(
            ['user_id' => $this->admin->id],
            [
                'bank_name' => 'Test Bank',
                'account_number' => '1234567890',
                'account_title' => 'Test Admin Title',
                'easypaisa_number' => '03001234567',
                'jazzcash_number' => '03007654321',
            ]
        );

        // Setup Employee
        $this->employee = User::firstOrCreate(
            ['email' => 'employee_test@khyberpro.com'],
            [
                'name' => 'System Employee',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_EMPLOYEE,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );
        $this->employee->update([
            'role' => User::ROLE_EMPLOYEE,
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
        ]);

        // Setup Customer
        $this->customer = User::firstOrCreate(
            ['email' => 'customer_test@khyberpro.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_USER,
                'status' => User::STATUS_ACTIVE,
                'email_verified_at' => now(),
            ]
        );
        $this->customer->update([
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
        ]);

        // Setup Category
        $this->category = AdminCategory::firstOrCreate(
            ['slug' => 'electronics-test'],
            ['name' => 'Electronics Test', 'status' => 'published']
        );

        // Setup Product
        $this->product = AdminProduct::firstOrCreate(
            ['sku' => 'TEST-SKU-999'],
            [
                'name' => 'Test Gaming Mouse',
                'slug' => 'test-gaming-mouse',
                'regular_price' => 150.00,
                'sale_price' => 120.00,
                'category_id' => $this->category->id,
                'status' => 'published',
                'stock_status' => 'in_stock',
                'quantity' => 25,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION 1: PUBLIC STOREFRONT & STATIC PAGES
    |--------------------------------------------------------------------------
    */

    public function test_public_pages_render_successfully(): void
    {
        $publicRoutes = [
            'home' => '/',
            'shop' => '/shop',
            'about' => '/about',
            'contact' => '/contact',
            'faqs' => '/faqs',
            'shipping' => '/shipping',
            'returns' => '/returns',
            'terms' => '/terms',
            'privacy' => '/privacy',
            'compare' => '/compare',
            'sitemap' => '/sitemap.xml',
            'product_detail' => '/product/' . $this->product->id,
            'category_detail' => '/category/' . $this->category->slug,
        ];

        foreach ($publicRoutes as $name => $uri) {
            $response = $this->get($uri);
            $this->assertTrue(
                in_array($response->status(), [200, 302]),
                "Route {$name} ({$uri}) returned unexpected status: " . $response->status()
            );
        }
    }

    public function test_public_search_and_suggestions(): void
    {
        $searchResponse = $this->get('/search?query=Gaming');
        $searchResponse->assertStatus(200);

        $suggestResponse = $this->get('/search/suggest?query=Gam');
        $suggestResponse->assertStatus(200);
        $suggestResponse->assertJsonStructure();
    }

    public function test_public_quick_view_api(): void
    {
        $response = $this->get('/api/product/' . $this->product->id . '/quick-view');
        $response->assertStatus(200);
    }

    public function test_public_newsletter_subscription(): void
    {
        $response = $this->post('/newsletter', [
            'email' => 'subscriber_' . uniqid() . '@example.com',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_contact_form_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello team!',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_recently_viewed_clear(): void
    {
        $response = $this->post('/recently-viewed/clear');
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION 2: CUSTOMER / USER WORKFLOW
    |--------------------------------------------------------------------------
    */

    public function test_customer_dashboard_access_and_redirection(): void
    {
        $response = $this->actingAs($this->customer)->get('/dashboard');
        $response->assertRedirect(route('user.dashboard'));

        $dash = $this->actingAs($this->customer)->get(route('user.dashboard'));
        $dash->assertStatus(200);
    }

    public function test_customer_cart_operations(): void
    {
        // Add to cart
        $addResponse = $this->actingAs($this->customer)->post('/cart/' . $this->product->id, [
            'quantity' => 2,
        ]);
        $addResponse->assertRedirect();

        // Update cart
        $updateResponse = $this->actingAs($this->customer)->patch('/cart/' . $this->product->id, [
            'quantity' => 3,
        ]);
        $updateResponse->assertRedirect();

        // Cart list view
        $listView = $this->actingAs($this->customer)->get('/cart-list/products');
        $listView->assertStatus(200);

        // Remove from cart
        $removeResponse = $this->actingAs($this->customer)->delete('/cart/' . $this->product->id);
        $removeResponse->assertRedirect();
    }

    public function test_customer_wishlist_operations(): void
    {
        // Toggle wishlist
        $toggle = $this->actingAs($this->customer)->post('/wishlist/' . $this->product->id . '/toggle');
        $toggle->assertRedirect();

        // View wishlist
        $view = $this->actingAs($this->customer)->get('/user/wishlist');
        $view->assertStatus(200);

        // Remove from wishlist
        $remove = $this->actingAs($this->customer)->delete('/wishlist/' . $this->product->id);
        $remove->assertRedirect();
    }

    public function test_customer_settings_profile_and_password(): void
    {
        $settingsView = $this->actingAs($this->customer)->get('/user/dashboard-settings');
        $settingsView->assertStatus(200);

        // Update profile
        $updateProfile = $this->actingAs($this->customer)->patch('/user/settings/profile', [
            'name' => 'Updated Customer Name',
            'phone' => '03009999999',
            'city' => 'Lahore',
            'country' => 'Pakistan',
            'address' => 'Street 10, Lahore',
        ]);
        $updateProfile->assertRedirect();

        // Update password
        $updatePassword = $this->actingAs($this->customer)->patch('/user/settings/password', [
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $updatePassword->assertRedirect();

        // Revert password
        $this->customer->update(['password' => Hash::make('password123')]);
    }

    public function test_customer_shipping_addresses_crud(): void
    {
        // Store address
        $store = $this->actingAs($this->customer)->post('/user/settings/shipping-addresses', [
            'label' => 'Home',
            'full_name' => 'Test Customer',
            'phone' => '03001234567',
            'address' => 'Plot 55',
            'city' => 'Peshawar',
            'state' => 'KP',
            'country' => 'PK',
            'postal_code' => '25000',
        ]);
        $store->assertRedirect();

        $address = ShippingAddress::where('user_id', $this->customer->id)->latest()->first();
        $this->assertNotNull($address);

        // Set default
        $setDefault = $this->actingAs($this->customer)->post('/user/settings/shipping-addresses/' . $address->id . '/default');
        $setDefault->assertRedirect();

        // Delete address
        $delete = $this->actingAs($this->customer)->delete('/user/settings/shipping-addresses/' . $address->id);
        $delete->assertRedirect();
    }

    public function test_customer_payment_methods_crud(): void
    {
        // Store payment method
        $store = $this->actingAs($this->customer)->post('/user/settings/payment-methods', [
            'type' => 'easypaisa',
            'account_title' => 'Customer EP',
            'account_number' => '03001112233',
        ]);
        $store->assertRedirect();

        $pm = UserPaymentMethod::where('user_id', $this->customer->id)->latest()->first();
        $this->assertNotNull($pm);

        // Delete payment method
        $delete = $this->actingAs($this->customer)->delete('/user/settings/payment-methods/' . $pm->id);
        $delete->assertRedirect();

        // Restore payment method
        $restore = $this->actingAs($this->customer)->post('/user/settings/payment-methods/' . $pm->id . '/restore');
        $restore->assertRedirect();
    }

    public function test_customer_order_history_and_details(): void
    {
        $history = $this->actingAs($this->customer)->get('/user/order-history');
        $history->assertStatus(200);

        $export = $this->actingAs($this->customer)->get('/user/order-history/export');
        $this->assertTrue(in_array($export->status(), [200, 302]));

        $details = $this->actingAs($this->customer)->get('/user/details');
        $details->assertStatus(200);
    }

    public function test_customer_product_review_and_question(): void
    {
        // Review submission
        $review = $this->actingAs($this->customer)->post('/product/' . $this->product->id . '/review', [
            'name' => 'Reviewer Name',
            'email' => 'reviewer@example.com',
            'rating' => 5,
            'review' => 'Exceptional product quality and fast delivery!',
        ]);
        $review->assertRedirect();

        // Question submission
        $question = $this->actingAs($this->customer)->post('/product/' . $this->product->id . '/question', [
            'question' => 'Does this come with extra buttons?',
        ]);
        $question->assertRedirect();
    }

    public function test_customer_product_reservation(): void
    {
        $reserve = $this->actingAs($this->customer)->post('/user/reserve/' . $this->product->id);
        $reserve->assertRedirect();
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION 3: EMPLOYEE PORTAL WORKFLOW
    |--------------------------------------------------------------------------
    */

    public function test_employee_dashboard_and_order_statuses(): void
    {
        $dashboard = $this->actingAs($this->employee)->get('/employee');
        $dashboard->assertStatus(200);
        $dashboard->assertSee('Dashboard');

        $statuses = ['all', 'ordered', 'completed', 'cancelled', 'refunded', 'on-hold'];
        foreach ($statuses as $status) {
            $ordersView = $this->actingAs($this->employee)->get('/employee/orders/' . $status);
            $ordersView->assertStatus(200);
        }
    }

    public function test_employee_products_and_favorites(): void
    {
        $products = $this->actingAs($this->employee)->get('/employee/products');
        $products->assertStatus(200);

        $detail = $this->actingAs($this->employee)->get('/employee/product/' . $this->product->id);
        $detail->assertStatus(200);

        $favToggle = $this->actingAs($this->employee)->post('/employee/product/' . $this->product->id . '/favorite');
        $favToggle->assertRedirect();

        $favs = $this->actingAs($this->employee)->get('/employee/products/favorites');
        $favs->assertStatus(200);
    }

    public function test_employee_reservation_full_lifecycle(): void
    {
        // View reservations
        $index = $this->actingAs($this->employee)->get('/employee/reservations');
        $index->assertStatus(200);

        $createView = $this->actingAs($this->employee)->get('/employee/reservations/create');
        $createView->assertStatus(200);

        // Store reservation
        $store = $this->actingAs($this->employee)->post('/employee/reservations', [
            'product_id' => $this->product->id,
        ]);
        $store->assertRedirect(route('employee.reservations.index'));

        $reservation = Reservation::where('user_id', $this->employee->id)
            ->where('product_id', $this->product->id)
            ->latest()
            ->first();
        $this->assertNotNull($reservation);

        // Order from reservation view
        $orderCreateView = $this->actingAs($this->employee)->get('/employee/reservations/' . $reservation->id . '/create-order');
        $orderCreateView->assertStatus(200);

        // Store order from reservation
        $orderStore = $this->actingAs($this->employee)->post('/employee/reservations/' . $reservation->id . '/create-order', [
            'order_number' => 'EMP-ORD-' . uniqid(),
            'paypal_email' => 'buyer@example.com',
            'amz_review_link' => 'https://amazon.com/review/R123456',
        ]);
        $orderStore->assertRedirect();

        // Create second reservation to test release
        $this->actingAs($this->employee)->post('/employee/reservations', [
            'product_id' => $this->product->id,
        ]);
        $res2 = Reservation::where('user_id', $this->employee->id)->where('status', 'pending')->first();
        if ($res2) {
            $release = $this->actingAs($this->employee)->delete('/employee/reservations/' . $res2->id);
            $release->assertRedirect();
        }
    }

    public function test_employee_paypal_blacklist_checker(): void
    {
        $blacklistPage = $this->actingAs($this->employee)->get('/employee/paypal-blacklisted');
        $blacklistPage->assertStatus(200);

        // Test blacklisted scammer email
        $scamSearch = $this->actingAs($this->employee)->get('/employee/paypal-blacklisted?paypal_email=scammer@example.com');
        $scamSearch->assertStatus(200);
        $scamSearch->assertSee('Blacklisted');

        // Test clean email
        $cleanSearch = $this->actingAs($this->employee)->get('/employee/paypal-blacklisted?paypal_email=cleanbuyer@gmail.com');
        $cleanSearch->assertStatus(200);
        $cleanSearch->assertSee('Clean');
    }

    public function test_employee_operational_pages(): void
    {
        // Delay refunds
        $delay = $this->actingAs($this->employee)->get('/employee/delay-refunds');
        $delay->assertStatus(200);

        // Admins management directory
        $admins = $this->actingAs($this->employee)->get('/employee/admins');
        $admins->assertStatus(200);
        $admins->assertSee('Osama Ahmed');

        // Support
        $support = $this->actingAs($this->employee)->get('/employee/support');
        $support->assertStatus(200);

        // Change password form
        $pwView = $this->actingAs($this->employee)->get('/employee/change-password');
        $pwView->assertStatus(200);

        // Profile view & update
        $profView = $this->actingAs($this->employee)->get('/employee/profile');
        $profView->assertStatus(200);

        $profUpdate = $this->actingAs($this->employee)->post('/employee/profile', [
            'name' => 'Updated Employee Name',
            'phone' => '03001122334',
            'city' => 'Islamabad',
            'country' => 'Pakistan',
        ]);
        $profUpdate->assertRedirect();

        // Excel creation view
        $excelView = $this->actingAs($this->employee)->get('/employee/excel/create');
        $excelView->assertStatus(200);
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION 4: ADMIN MANAGEMENT WORKFLOW
    |--------------------------------------------------------------------------
    */

    public function test_admin_dashboard_and_inventory_alerts(): void
    {
        $dash = $this->actingAs($this->admin)->get('/admin');
        $dash->assertStatus(200);
        $dash->assertSee('Dashboard');
    }

    public function test_admin_employee_management(): void
    {
        // Employee listing
        $list = $this->actingAs($this->admin)->get('/admin/employees');
        $list->assertStatus(200);

        // Create new employee
        $create = $this->actingAs($this->admin)->post('/admin/employees', [
            'name' => 'New Staff Member',
            'email' => 'staff_' . uniqid() . '@khyberpro.com',
            'password' => 'staffpassword123',
            'phone' => '03009988776',
            'status' => 'active',
        ]);
        $create->assertRedirect(route('admin.employees.index'));

        // Toggle employee status
        $statusToggle = $this->actingAs($this->admin)->patch('/admin/employees/' . $this->employee->id . '/status', [
            'status' => 'active',
        ]);
        $statusToggle->assertRedirect();

        // Reset employee password
        $resetPw = $this->actingAs($this->admin)->post('/admin/employees/' . $this->employee->id . '/reset-password', [
            'password' => 'resetpassword123',
            'password_confirmation' => 'resetpassword123',
        ]);
        $resetPw->assertRedirect();

        // View admins directory
        $admins = $this->actingAs($this->admin)->get('/admin/admins');
        $admins->assertStatus(200);
    }

    public function test_admin_category_management(): void
    {
        $addView = $this->actingAs($this->admin)->get('/admin/add-category');
        $addView->assertStatus(200);

        // Create category
        $slug = 'test-new-cat-' . uniqid();
        $create = $this->actingAs($this->admin)->post('/admin/add-category', [
            'name' => 'Category ' . $slug,
            'slug' => $slug,
            'status' => 'published',
        ]);
        $create->assertRedirect();

        // View categories
        $view = $this->actingAs($this->admin)->get('/admin/view-category');
        $view->assertStatus(200);

        // Export categories
        $export = $this->actingAs($this->admin)->get('/admin/view-category/export');
        $this->assertTrue(in_array($export->status(), [200, 302]));
    }

    public function test_admin_product_management(): void
    {
        $addView = $this->actingAs($this->admin)->get('/admin/add-product');
        $addView->assertStatus(200);

        // View products
        $view = $this->actingAs($this->admin)->get('/admin/view-product');
        $view->assertStatus(200);

        // Export products
        $export = $this->actingAs($this->admin)->get('/admin/view-product/export');
        $this->assertTrue(in_array($export->status(), [200, 302]));

        // Show product
        $show = $this->actingAs($this->admin)->get('/admin/show-product/' . $this->product->id);
        $show->assertStatus(200);

        // Toggle product status
        $toggleStatus = $this->actingAs($this->admin)->patch('/admin/product-status/' . $this->product->id);
        $toggleStatus->assertRedirect();

        // Import view
        $importView = $this->actingAs($this->admin)->get('/admin/import-products');
        $importView->assertStatus(200);
    }

    public function test_admin_order_management(): void
    {
        // Orders listing
        $orders = $this->actingAs($this->admin)->get('/admin/orders');
        $orders->assertStatus(200);

        // Orders export
        $export = $this->actingAs($this->admin)->get('/admin/orders/export');
        $this->assertTrue(in_array($export->status(), [200, 302]));

        // Order details view
        $details = $this->actingAs($this->admin)->get('/admin/order-details');
        $details->assertStatus(200);
    }

    public function test_admin_customer_management(): void
    {
        // Users list
        $users = $this->actingAs($this->admin)->get('/admin/users');
        $users->assertStatus(200);

        // Users export
        $export = $this->actingAs($this->admin)->get('/admin/users/export');
        $this->assertTrue(in_array($export->status(), [200, 302]));

        // Show user
        $show = $this->actingAs($this->admin)->get('/admin/users/' . $this->customer->id);
        $show->assertStatus(200);

        // Toggle customer status
        $status = $this->actingAs($this->admin)->patch('/admin/users/' . $this->customer->id . '/status', [
            'status' => 'active',
        ]);
        $status->assertRedirect();
    }

    public function test_admin_recycle_bin_and_activity(): void
    {
        $bin = $this->actingAs($this->admin)->get('/admin/recycle-bin');
        $bin->assertStatus(200);

        $activity = $this->actingAs($this->admin)->get('/admin/activity');
        $activity->assertStatus(200);
    }

    public function test_admin_reviews_and_questions(): void
    {
        $reviews = $this->actingAs($this->admin)->get('/admin/reviews');
        $reviews->assertStatus(200);

        $questions = $this->actingAs($this->admin)->get('/admin/questions');
        $questions->assertStatus(200);
    }

    public function test_admin_global_user_message(): void
    {
        $msgView = $this->actingAs($this->admin)->get('/admin/user-message');
        $msgView->assertStatus(200);

        $msgUpdate = $this->actingAs($this->admin)->post('/admin/user-message', [
            'message' => 'Special promotion today only!',
            'is_active' => '1',
        ]);
        $msgUpdate->assertRedirect();
    }

    public function test_admin_operational_screens(): void
    {
        $profile = $this->actingAs($this->admin)->get('/admin/profile');
        $profile->assertStatus(200);

        $changePw = $this->actingAs($this->admin)->get('/admin/change-password');
        $changePw->assertStatus(200);

        $support = $this->actingAs($this->admin)->get('/admin/support');
        $support->assertStatus(200);

        $delayRefunds = $this->actingAs($this->admin)->get('/admin/delay-refunds');
        $delayRefunds->assertStatus(200);

        $paypalBlacklist = $this->actingAs($this->admin)->get('/admin/paypal/blacklisted');
        $paypalBlacklist->assertStatus(200);

        $reservations = $this->actingAs($this->admin)->get('/admin/reservations');
        $reservations->assertStatus(200);

        $createReservation = $this->actingAs($this->admin)->get('/admin/reservations/create');
        $createReservation->assertStatus(200);

        $excel = $this->actingAs($this->admin)->get('/admin/excel/create');
        $excel->assertStatus(200);
    }

    /*
    |--------------------------------------------------------------------------
    | SECTION 5: ROLE & SECURITY RESTRICTIONS
    |--------------------------------------------------------------------------
    */

    public function test_role_enforcement_and_unauthorized_access(): void
    {
        // Customer cannot access admin routes
        $response = $this->actingAs($this->customer)->get('/admin');
        $response->assertRedirect(route('user.dashboard'));

        // Customer cannot access employee routes
        $empAccess = $this->actingAs($this->customer)->get('/employee');
        $empAccess->assertRedirect(route('user.dashboard'));

        // Employee cannot access admin routes
        $adminAccess = $this->actingAs($this->employee)->get('/admin');
        $adminAccess->assertRedirect(route('employee.dashboard'));

        // Log out before testing unauthenticated guest access
        $this->post('/logout');

        // Unauthenticated guests redirected to login
        $guestAdmin = $this->get('/admin');
        $guestAdmin->assertRedirect(route('login'));

        $guestEmp = $this->get('/employee');
        $guestEmp->assertRedirect(route('login'));

        $guestUser = $this->get('/user');
        $guestUser->assertRedirect(route('login'));
    }
}
