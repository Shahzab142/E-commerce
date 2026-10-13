<?php
namespace App\Livewire\Admin\Authentication;

use App\Models\User;
use App\Mail\VerificationCodeEmail;
use App\Services\CaptchaService;
use App\Services\UserRegistrationService;
use App\Services\VerificationCodeService;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest-bootstrap')]
class Signup extends Component
{
    public $name = '';

    public $email = '';

    public $phone = '';

    public $country = '';

    public $state = '';

    public $city = '';

    public $postal_code = '';

    public $address = '';

    public $easypaisa_number = '';

    public $easypaisa_account_title = '';

    public $jazzcash_number = '';

    public $jazzcash_account_title = '';

    public $bank_name = '';

    public $account_title = '';

    public $account_number = '';

    public $iban = '';

    public $password = '';

    public $password_confirmation = '';

    public $captcha_answer = '';

    public $captcha = [];

    /**
     * Allow only one administrator.
     */
    public function mount()
    {
        if (User::where('role', User::ROLE_ADMIN)->exists()) {
            return redirect()->route('login');
        }

        $this->refreshCaptcha();
    }

    /**
     * Refresh the CAPTCHA puzzle.
     */
    public function refreshCaptcha(): void
    {
        $captchaService = app(CaptchaService::class);
        $this->captcha = $captchaService->generate();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|string',
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string',
            'easypaisa_number' => 'nullable|string|max:50',
            'easypaisa_account_title' => 'nullable|string|max:255',
            'jazzcash_number' => 'nullable|string|max:50',
            'jazzcash_account_title' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'account_title' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'iban' => 'nullable|string|max:255',
            'captcha_answer' => app()->environment('testing') ? 'nullable|string' : 'required|string',
        ];
    }

    public function register(UserRegistrationService $service)
    {
        $validated = $this->validate();

        if ($validated === []) {
            return;
        }

        // Validate CAPTCHA (bypassed inside the test suite; covered by CaptchaServiceTest)
        $captchaService = app(CaptchaService::class);
        if (! app()->environment('testing') && ! $captchaService->validate($this->captcha_answer)) {
            $this->refreshCaptcha();
            $this->addError('captcha_answer', 'The CAPTCHA answer is incorrect. Please try again.');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Double Check
        |--------------------------------------------------------------------------
        */

        if (
            User::where('role', User::ROLE_ADMIN)->exists()
        ) {

            $this->addError(
                'email',
                'An administrator account already exists.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | User Data
        |--------------------------------------------------------------------------
        */

        $userData = [

            'name' => $this->name,

            'email' => $this->email,

            'phone' => $this->phone,

            'password' => $this->password,

        ];

        /*
        |--------------------------------------------------------------------------
        | Admin Details
        |--------------------------------------------------------------------------
        */

        $detailsData = [

            'country' => $this->country,

            'state' => $this->state,

            'city' => $this->city,

            'postal_code' => $this->postal_code,

            'address' => $this->address,

            'easypaisa_number' => $this->easypaisa_number,

            'easypaisa_account_title' => $this->easypaisa_account_title,

            'jazzcash_number' => $this->jazzcash_number,

            'jazzcash_account_title' => $this->jazzcash_account_title,

            'bank_name' => $this->bank_name,

            'account_title' => $this->account_title,

            'account_number' => $this->account_number,

            'iban' => $this->iban,

        ];

        /*
        |--------------------------------------------------------------------------
        | Register Admin
        |--------------------------------------------------------------------------
        */

        $admin = $service->register(

            $userData,

            $detailsData,

            User::ROLE_ADMIN,

            'adminDetail'

        );

        // Send the 6-digit email verification code.
        try {
            $codeService = app(VerificationCodeService::class);
            $result = $codeService->generate($admin->email);

            Mail::to($admin->email)->send(
                new VerificationCodeEmail(
                    $result['code'],
                    $result['expires_at']->format('g:i A'),
                    'signup'
                )
            );
        } catch (\Exception $e) {
            // If the code email fails, the user can resend from the
            // verification page.
        }

        // The admin is NOT logged in until the code is confirmed.
        session([
            'verification_email' => $admin->email,
            'verification_context' => 'signup',
        ]);

        $this->redirectRoute('verification.verify-code', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.authentication.signup');
    }
}
