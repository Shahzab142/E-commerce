<?php

namespace Tests\Feature;

use App\Models\AdminCategory;
use App\Models\AdminProduct;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EmployeePortalTest extends TestCase
{
    protected User $employee;

    protected function setUp(): void
    {
        parent::setUp();

        $this->employee = User::firstOrCreate(
            ['email' => 'employee@khyberpro.com'],
            [
                'name' => 'Khyber Employee',
                'password' => Hash::make('employee123'),
                'role' => 'employee',
                'status' => 'active',
            ]
        );
        $this->employee->update(['role' => 'employee', 'status' => 'active']);
    }

    public function test_employee_dashboard_renders_successfully(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_employee_orders_pages_render_successfully(): void
    {
        $statuses = ['all', 'ordered', 'completed', 'cancelled', 'refunded', 'on-hold'];

        foreach ($statuses as $status) {
            $response = $this->actingAs($this->employee)->get(route('employee.orders', $status));
            $response->assertStatus(200);
        }
    }

    public function test_employee_products_page_renders(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.products'));
        $response->assertStatus(200);

        $favResponse = $this->actingAs($this->employee)->get(route('employee.products', 'favorites'));
        $favResponse->assertStatus(200);
    }

    public function test_employee_product_detail_and_favorite_toggle(): void
    {
        $category = AdminCategory::firstOrCreate(
            ['slug' => 'test-cat'],
            ['name' => 'Test Cat', 'status' => 'published']
        );

        $product = AdminProduct::firstOrCreate(
            ['sku' => 'EMP-TEST-1'],
            [
                'name' => 'Test Employee Product',
                'regular_price' => 100,
                'sale_price' => 80,
                'category_id' => $category->id,
                'status' => 'published',
                'quantity' => 10,
            ]
        );

        $detailResponse = $this->actingAs($this->employee)->get(route('employee.product.detail', $product->id));
        $detailResponse->assertStatus(200);

        $favToggle = $this->actingAs($this->employee)->post(route('employee.product.favorite.toggle', $product->id));
        $favToggle->assertRedirect();
    }

    public function test_employee_reservations_pages_and_flow(): void
    {
        $indexResponse = $this->actingAs($this->employee)->get(route('employee.reservations.index'));
        $indexResponse->assertStatus(200);

        $createResponse = $this->actingAs($this->employee)->get(route('employee.reservations.create'));
        $createResponse->assertStatus(200);

        $product = AdminProduct::first();
        if ($product) {
            // Test storing reservation
            $storeResponse = $this->actingAs($this->employee)->post(route('employee.reservations.store'), [
                'product_id' => $product->id,
            ]);
            $storeResponse->assertRedirect(route('employee.reservations.index'));

            $reservation = Reservation::where('user_id', $this->employee->id)
                ->where('product_id', $product->id)
                ->first();

            if ($reservation) {
                // Test order create form from reservation
                $orderFormResponse = $this->actingAs($this->employee)->get(route('employee.reservations.order.create', $reservation->id));
                $orderFormResponse->assertStatus(200);

                // Test release reservation
                $releaseResponse = $this->actingAs($this->employee)->delete(route('employee.reservations.release', $reservation->id));
                $releaseResponse->assertRedirect(route('employee.reservations.index'));
            }
        }
    }

    public function test_employee_change_password_page_and_validation(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.change-password'));
        $response->assertStatus(200);

        $badPasswordResponse = $this->actingAs($this->employee)->post(route('employee.change-password.update'), [
            'old_password' => 'wrongpassword',
            'new_password' => 'newsecret123',
            'new_password_confirmation' => 'newsecret123',
        ]);
        $badPasswordResponse->assertSessionHasErrors('old_password');
    }

    public function test_employee_profile_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.profile'));
        $response->assertStatus(200);
        $response->assertSee($this->employee->name);
    }

    public function test_employee_admins_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.admins'));
        $response->assertStatus(200);
        $response->assertSee('Osama Ahmed');
    }

    public function test_employee_excel_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.excel.create'));
        $response->assertStatus(200);
    }

    public function test_employee_support_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.support'));
        $response->assertStatus(200);
    }

    public function test_employee_paypal_blacklist_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.paypal.blacklisted'));
        $response->assertStatus(200);

        $searchFound = $this->actingAs($this->employee)->get(route('employee.paypal.blacklisted', ['paypal_email' => 'scammer@example.com']));
        $searchFound->assertStatus(200);
        $searchFound->assertSee('Blacklisted');

        $searchClean = $this->actingAs($this->employee)->get(route('employee.paypal.blacklisted', ['paypal_email' => 'clean@example.com']));
        $searchClean->assertStatus(200);
        $searchClean->assertSee('Account is Clean');
    }

    public function test_employee_delay_refunds_page(): void
    {
        $response = $this->actingAs($this->employee)->get(route('employee.delay-refunds'));
        $response->assertStatus(200);
    }
}
