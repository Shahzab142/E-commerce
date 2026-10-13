<?php

use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminProductController;
use App\Http\Controllers\admin\AdminReviewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartListController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;

use App\Http\Controllers\PageController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\EnsureEmailVerified;
use App\Models\AdminCategory;

use App\Livewire\Admin\Authentication\Signup as AdminSignup;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');


Route::get('/sitemap.xml', function () {
    $urls = collect([
        ['loc' => route('home'), 'lastmod' => now()->toAtomString()],
    ])->merge(
        AdminCategory::query()
            ->where('status', 'published')
            ->get(['slug', 'updated_at'])
            ->map(fn (AdminCategory $category): array => [
                'loc' => url('/category/'.$category->slug),
                'lastmod' => $category->updated_at?->toAtomString(),
            ])
    );

    $xml = view('sitemap', ['urls' => $urls])->render();

    return response($xml, 200)->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/run-migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        $output = \Illuminate\Support\Facades\Artisan::output();

        return response()->json([
            'status' => 'success',
            'output' => $output,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});

Route::get('/debug-db', function () {
    try {
        $tables = \Illuminate\Support\Facades\DB::select("SELECT name FROM sqlite_master WHERE type='table'");
        return response()->json([
            'tables' => array_column($tables, 'name'),
        ]);
    } catch (\Throwable $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    return back()->with('success', 'Thank you for contacting us!');
})->name('contact.store');

use App\Models\AdminDetail;

Route::get('/about', function () {
    $adminDetails = AdminDetail::first();
    return view('about', compact('adminDetails'));
})->name('about');
Route::get('/contact', fn () => view('contact'))->name('contact');
Route::get('/faqs', fn () => view('faqs'))->name('faqs');
Route::get('/shipping', fn () => view('shipping'))->name('shipping');
Route::get('/returns', fn () => view('returns'))->name('returns');
Route::get('/track-order', [PageController::class, 'trackOrder'])->name('track.order.submit');
Route::get('/terms', fn () => view('terms'))->name('terms');
Route::get('/privacy', fn () => view('privacy'))->name('privacy');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');

Route::post('/newsletter', function (\Illuminate\Http\Request $request) {
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
        'email' => 'required|email',
    ]);
    if ($validator->fails()) {
        return back()->withErrors($validator, 'newsletter')->withInput();
    }
    $subscriber = \App\Models\NewsletterSubscriber::firstOrNew(['email' => $request->email]);
    $subscriber->is_active = true;
    $subscriber->unsubscribed_at = null;
    $subscriber->save();
    return back()->with('success', 'Thank you for subscribing!')->with('newsletter_success', true);
})->name('newsletter.subscribe');

Route::get('/category/{slug}', [CategoryController::class, 'detail']);

Route::get('/category/electronics/{slug}', [CategoryController::class, 'detail']);

Route::get('/product/{id}', [ProductDetailController::class, 'detail'])
    ->name('product.detail');

Route::post('/product/{id}/question', [ProductDetailController::class, 'storeQuestion'])
    ->name('product.question')
    ->middleware('auth');

Route::post('/recently-viewed/clear', function () {
    session()->forget('recently_viewed');
    return response()->json(['success' => true]);
})->name('recently-viewed.clear');

Route::get('/compare', function () {
    return view('compare');
})->name('compare');

Route::get('/api/product/{id}/quick-view', [ProductDetailController::class, 'quickView']);

Route::get('/search', SearchController::class)
    ->name('search');

Route::get('/search/suggest', [SearchController::class, 'suggest'])
    ->name('search.suggest');

Route::post('/product/{product}/review', [ReviewController::class, 'store'])
    ->name('review.store');

Route::patch('/review/{review}/reply', [ReviewController::class, 'reply'])
    ->middleware('auth')
    ->name('review.reply');

Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');

Route::delete('/wishlist/{product}', [WishlistController::class, 'remove'])
    ->middleware('auth')
    ->name('wishlist.remove');

Route::post('/cart/{product}', [CartListController::class, 'add'])
    ->name('cart.add');

Route::patch('/cart/{product}', [CartListController::class, 'update'])
    ->name('cart.update');

Route::delete('/cart/{product}', [CartListController::class, 'remove'])
    ->name('cart.remove');

Route::get('/checkout/{slug}', [CheckoutController::class, 'order'])
    ->name('checkout.form');

Route::post('/checkout/{slug}', [CheckoutController::class, 'place'])
    ->name('checkout.place');

Route::get('/checkout/{slug}/stripe/success', [CheckoutController::class, 'stripeSuccess'])
    ->name('checkout.stripe.success');

Route::get('/checkout/{slug}/stripe/cancel', [CheckoutController::class, 'stripeCancel'])
    ->name('checkout.stripe.cancel');

Route::get('/cart-list/{slug}', [CartListController::class, 'list'])
    ->name('cart.list');

Route::post('/cart/{slug}/coupon/apply', [CartListController::class, 'applyCoupon'])
    ->middleware(['auth', 'role:user'])
    ->name('cart.coupon.apply');

Route::delete('/cart/{slug}/coupon/remove', [CartListController::class, 'removeCoupon'])
    ->middleware(['auth', 'role:user'])
    ->name('cart.coupon.remove');


/*
|--------------------------------------------------------------------------
| Registration Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin-signup', AdminSignup::class)
    ->name('admin.signup');


/*
|--------------------------------------------------------------------------
| Logout Route
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return redirect()->route('login');

})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Main Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        return redirect()->route(
            auth()->user()->dashboardRoute()
        );

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:admin', EnsureEmailVerified::class])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | Admin Dashboard
            |--------------------------------------------------------------------------
            */

            Route::get('/', [AdminController::class, 'admin'])
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | Employee Management Routes
            |--------------------------------------------------------------------------
            */
            Route::get('/employees', [AdminController::class, 'employees'])->name('employees.index');
            Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('employees.store');
            Route::patch('/employees/{user}/status', [AdminController::class, 'updateEmployeeStatus'])->name('employees.status');
            Route::post('/employees/{user}/reset-password', [AdminController::class, 'resetEmployeePassword'])->name('employees.reset-password');
            Route::delete('/employees/{user}', [AdminController::class, 'deleteEmployee'])->name('employees.delete');
            Route::get('/admins', [AdminController::class, 'admins'])->name('admins');

            /*
            |--------------------------------------------------------------------------
            | New Client Requirement Routes
            |--------------------------------------------------------------------------
            */
            Route::get('/excel/create', [AdminController::class, 'createExcel'])->name('excel.create');
            Route::post('/excel/create', [AdminController::class, 'generateExcel'])->name('excel.generate');
            Route::get('/paypal/blacklisted', [AdminController::class, 'blacklistedPaypal'])->name('paypal.blacklisted');
            Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations.index');
            Route::get('/reservations/create', [AdminController::class, 'createReservation'])->name('reservations.create');
            
            Route::get('/user-message', [\App\Http\Controllers\AdminUserMessageController::class, 'index'])->name('user-message.index');
            Route::post('/user-message', [\App\Http\Controllers\AdminUserMessageController::class, 'update'])->name('user-message.update');


            /*
            |--------------------------------------------------------------------------
            | Category Routes
            |--------------------------------------------------------------------------
            */

            // Show Add Category Form
            Route::get('/add-category', [AdminCategoryController::class, 'add_category'])
                ->name('categories.add');


            // Store New Category
            Route::post('/add-category', [AdminCategoryController::class, 'create_category'])
                ->name('categories.store');

           // New Category
           Route::get('/category/{id}', [AdminCategoryController::class, 'show_category'])
    ->name('categories.show');
            // View All Categories
            Route::get('/view-category', [AdminCategoryController::class, 'view_category'])
                ->name('categories.view');

            Route::get('/view-category/export', [ExportController::class, 'adminCategories'])
                ->name('categories.export');


            // Show Edit Category Form
            Route::get('/edit-category/{id}', [AdminCategoryController::class, 'edit_category'])
                ->name('categories.edit');


            // Update Category
            Route::put('/edit-category/{id}', [AdminCategoryController::class, 'update_category'])
                ->name('categories.update');


            // Delete Category
            Route::delete('/delete-category/{id}', [AdminCategoryController::class, 'delete_category'])
                ->name('categories.delete');


            /*
            |--------------------------------------------------------------------------
            | Product Routes
            |--------------------------------------------------------------------------
            */

            Route::get('/add-product', [AdminProductController::class, 'add_prodcut'])
                ->name('products.add');
            Route::post('/add-product', [AdminProductController::class, 'create_product'])
                ->name('products.create');

            Route::get('/import-products', [AdminProductController::class, 'import_view'])
                ->name('products.import_view');
            Route::post('/import-products', [AdminProductController::class, 'import_excel'])
                ->name('products.import_excel');

            Route::get('/view-product', [AdminProductController::class, 'view_product'])
                ->name('products.view');

            Route::get('/view-product/export', [ExportController::class, 'adminProducts'])
                ->name('products.export');

                 Route::get('/show-product/{id}', [AdminProductController::class, 'show_product'])
                ->name('products.show');

            Route::get('/edit-product/{id}', [AdminProductController::class, 'edit_product'])
                ->name('products.edit');

                Route::put('/edit-product/{id}', [AdminProductController::class, 'update_product'])
                ->name('products.update');
Route::delete('/delete-product/{id}', [AdminProductController::class, 'delete_product'])
                ->name('products.delete');

            Route::patch('/product-status/{product}', [AdminProductController::class, 'updateProductStatus'])
                ->name('products.status');




            /*
            |--------------------------------------------------------------------------
            | Order Routes
            |--------------------------------------------------------------------------
            */

            Route::get('/orders', [AdminController::class, 'show_orders'])
                ->name('orders.index');

            Route::get('/orders/export', [ExportController::class, 'adminOrders'])
                ->name('orders.export');

            Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])
                ->name('orders.status');

            Route::delete('/orders/{order}/delete', [AdminController::class, 'deleteCancelledOrder'])
                ->name('orders.delete');

            Route::get('/order-details/{id?}', [AdminController::class, 'order_details'])
                ->name('orders.details');


            /*
            |--------------------------------------------------------------------------
            | User Routes
            |--------------------------------------------------------------------------
            */

            Route::get('/users', [AdminController::class, 'users'])
                ->name('users.index');

            Route::post('/users', [AdminController::class, 'storeUser'])
                ->name('users.store');

            Route::get('/users/export', [ExportController::class, 'adminUsers'])
                ->name('users.export');

            Route::get('/users/{user}', [AdminController::class, 'show_user'])
                ->name('users.show');

            Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])
                ->name('users.status');

            Route::delete('/users/{user}/delete', [AdminController::class, 'deleteCustomer'])
                ->name('users.delete');


            /*
            |--------------------------------------------------------------------------
            | Recycle Bin & Activity Log
            |--------------------------------------------------------------------------
            */

            Route::get('/recycle-bin', [AdminController::class, 'recycleBin'])
                ->name('recycle-bin');

            Route::post('/recycle-bin/orders/{id}/restore', [AdminController::class, 'restoreOrder'])
                ->name('orders.restore');

            Route::delete('/recycle-bin/orders/{id}', [AdminController::class, 'forceDeleteOrder'])
                ->name('orders.force-delete');

            Route::post('/recycle-bin/users/{id}/restore', [AdminController::class, 'restoreUser'])
                ->name('users.restore');

            Route::delete('/recycle-bin/users/{id}', [AdminController::class, 'forceDeleteUser'])
                ->name('users.force-delete');

            Route::post('/recycle-bin/accounts/{id}/reactivate', [AdminController::class, 'reactivateAccount'])
                ->name('accounts.reactivate');

            Route::post('/recycle-bin/orders/{id}/reactivate', [AdminController::class, 'restoreCancelledOrder'])
                ->name('orders.reactivate');

            Route::get('/activity', [AdminController::class, 'activity'])
                ->name('activity');

            Route::delete('/activity/{id}', [AdminController::class, 'deleteActivityLog'])
                ->name('activity.delete');


            /*
            |--------------------------------------------------------------------------
            | Review Routes
            |--------------------------------------------------------------------------
            */

            Route::get('/reviews', [AdminReviewController::class, 'index'])
                ->name('reviews.index');

            Route::patch('/reviews/{review}/status', [AdminReviewController::class, 'updateStatus'])
                ->name('reviews.status');

            Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])
                ->name('reviews.destroy');


            /*
            |--------------------------------------------------------------------------
            | Admin Profile
            |--------------------------------------------------------------------------
            */

            Route::get('/profile', [AdminController::class, 'profile'])
                ->name('profile');

            Route::patch('/profile', [AdminController::class, 'updateProfile'])
                ->name('profile.update');

            Route::get('/questions', [AdminController::class, 'questions'])
                ->name('questions.index');

            Route::patch('/questions/{question}/answer', [AdminController::class, 'answerQuestion'])
                ->name('questions.answer');

            Route::delete('/questions/{question}', [AdminController::class, 'destroyQuestion'])
                ->name('questions.destroy');

            /*
            |--------------------------------------------------------------------------
            | Admin Password, Support & Delayed Refunds
            |--------------------------------------------------------------------------
            */
            Route::get('/change-password', [AdminController::class, 'changePassword'])
                ->name('change-password');
            Route::post('/change-password', [AdminController::class, 'updatePassword'])
                ->name('change-password.update');

            Route::get('/support', [AdminController::class, 'support'])
                ->name('support');
            Route::post('/support', [AdminController::class, 'sendSupport'])
                ->name('support.send');

            Route::get('/delay-refunds', [AdminController::class, 'delayRefunds'])
                ->name('delay-refunds');
            Route::patch('/delay-refunds/{order}/status', [AdminController::class, 'updateRefundStatus'])
                ->name('delay-refunds.update-status');
        });


    /*
    |--------------------------------------------------------------------------
    | Employee Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:employee'])
        ->prefix('employee')
        ->name('employee.')
        ->group(function () {

            Route::get('/', [EmployeeController::class, 'dashboard'])->name('dashboard');
            Route::get('/orders/{status?}', [EmployeeController::class, 'orders'])->name('orders');
            Route::get('/products/{category?}', [EmployeeController::class, 'products'])->name('products');
            Route::get('/product/{id}', [EmployeeController::class, 'productDetail'])->name('product.detail');
            Route::post('/product/{id}/favorite', [EmployeeController::class, 'toggleFavorite'])->name('product.favorite.toggle');

            Route::get('/reservations', [EmployeeController::class, 'reservations'])->name('reservations.index');
            Route::get('/reservations/create', [EmployeeController::class, 'createReservation'])->name('reservations.create');
            Route::post('/reservations', [EmployeeController::class, 'storeReservation'])->name('reservations.store');
            Route::delete('/reservations/{id}', [EmployeeController::class, 'releaseReservation'])->name('reservations.release');
            Route::get('/reservations/{id}/create-order', [EmployeeController::class, 'createOrderFromReservation'])->name('reservations.order.create');
            Route::post('/reservations/{id}/create-order', [EmployeeController::class, 'storeOrderFromReservation'])->name('reservations.order.store');

            Route::get('/change-password', [EmployeeController::class, 'changePassword'])->name('change-password');
            Route::post('/change-password', [EmployeeController::class, 'updatePassword'])->name('change-password.update');

            Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
            Route::post('/profile', [EmployeeController::class, 'updateProfile'])->name('profile.update');

            Route::get('/admins', [EmployeeController::class, 'admins'])->name('admins');
            Route::get('/excel/create', [EmployeeController::class, 'createExcel'])->name('excel.create');
            Route::post('/excel/create', [EmployeeController::class, 'generateExcel'])->name('excel.generate');
            Route::get('/support', [EmployeeController::class, 'support'])->name('support');
            Route::get('/paypal-blacklisted', [EmployeeController::class, 'blacklistedPaypal'])->name('paypal.blacklisted');
            Route::get('/delay-refunds', [EmployeeController::class, 'delayRefunds'])->name('delay-refunds');
        });





    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware(['auth', 'role:user', EnsureEmailVerified::class])
        ->prefix('user')
        ->name('user.')
        ->group(function () {

            Route::get('/', [UserController::class, 'user'])
                ->name('dashboard');

            Route::get('/order-history', [UserController::class, 'history'])
                ->name('orders.history');

            Route::post('/reserve/{product}', [UserController::class, 'reserve'])
                ->name('reserve');

            Route::get('/order-history/export', [ExportController::class, 'userOrders'])
                ->name('orders.export');

            Route::get('/details/{id?}', [UserController::class, 'viewDetail'])
                ->name('details');

            Route::get('/dashboard-settings', [UserController::class, 'settings'])
                ->name('settings');

            Route::get('/wishlist', [WishlistController::class, 'index'])
                ->name('wishlist');

            Route::patch('/settings/profile', [UserController::class, 'updateSettings'])
                ->name('settings.update');

            Route::patch('/settings/password', [UserController::class, 'updatePassword'])
                ->name('settings.update-password');

            Route::post('/settings/payment-methods', [UserController::class, 'storePaymentMethod'])
                ->name('settings.payment-methods.store');

            Route::delete('/settings/payment-methods/{paymentMethod}', [UserController::class, 'deletePaymentMethod'])
                ->name('settings.payment-methods.delete');

            Route::post('/settings/payment-methods/{id}/restore', [UserController::class, 'restorePaymentMethod'])
                ->name('settings.payment-methods.restore');

            Route::post('/settings/shipping-addresses', [UserController::class, 'storeShippingAddress'])
                ->name('settings.shipping-addresses.store');

            Route::delete('/settings/shipping-addresses/{shippingAddress}', [UserController::class, 'deleteShippingAddress'])
                ->name('settings.shipping-addresses.delete');

            Route::post('/settings/shipping-addresses/{shippingAddress}/default', [UserController::class, 'setDefaultShippingAddress'])
                ->name('settings.shipping-addresses.default');
        });


    /*
    |--------------------------------------------------------------------------
    | Livewire Volt Settings
    |--------------------------------------------------------------------------
    */

    Volt::route('settings/profile', 'settings.profile')
        ->name('settings.profile');

    Volt::route('settings/password', 'settings.password')
        ->name('settings.password');

    Volt::route('settings/appearance', 'settings.appearance')
        ->name('settings.appearance');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
