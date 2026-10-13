<?php

use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        // Validate credentials WITHOUT authenticating, so that admin/vendor
        // users cannot access the site until they complete the verification-code
        // step.  Regular (ROLE_USER) accounts are authenticated immediately.
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Hash::check($this->password, User::where('email', $this->email)->value('password'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        /** @var User $user */
        $user = User::where('email', $this->email)->firstOrFail();

        // if ($user->isAdmin() || $user->isVendor()) {
        //     $codeService = app(VerificationCodeService::class);
        //     $result = $codeService->generate($user->email);
        //
        //     try {
        //         Mail::to($user->email)->send(new \App\Mail\VerificationCodeEmail($result['code'], $result['expires_at']->format('g:i A'), 'login'));
        //     } catch (\Exception $e) {
        //         Session::flash('error', 'Verification code could not be sent. Please try again.');
        //     }
        //
        //     // Store credentials temporarily so verify-code can log the user in
        //     // only after the code is validated.
        //     Session::regenerate();
        //     Session::put('verification_email', $user->email);
        //     Session::put('verification_context', 'login');
        //     Session::put('login_credentials', $credentials);
        //
        //     $this->redirectRoute('verification.verify-code', navigate: true);
        //     return;
        // }

        Auth::attempt($credentials, $this->remember);
        $this->redirectRoute(Auth::user()->dashboardRoute(), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
};
?>

<div>
<style>
    .material-group {
        margin-bottom: 30px;
    }
    .material-label {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 5px;
        display: block;
    }
    .material-input {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ccc;
        padding: 8px 0;
        font-size: 1rem;
        color: #333;
        background: transparent;
        outline: none;
        transition: border-color 0.2s;
    }
    .material-input:focus {
        border-bottom: 2px solid #5cb85c;
    }
    .btn-khybar {
        background-color: #5cb85c;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        margin-top: 20px;
        box-shadow: 0 4px 10px rgba(92, 184, 92, 0.3);
        transition: background-color 0.2s;
    }
    .btn-khybar:hover {
        background-color: #4cae4c;
        color: white;
    }
    .btn-khybar-outline {
        display: inline-block;
        background-color: transparent;
        color: #4f46e5;
        border: 2px solid #4f46e5;
        border-radius: 50px;
        padding: 12px 25px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }
    .btn-khybar-outline:hover {
        background-color: #4f46e5;
        color: white;
    }
</style>
<div style="max-width: 450px; margin: 0 auto; padding: 2rem 1rem;">
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit="login" novalidate>
        
        <div class="material-group">
            <label class="material-label" for="email">Email</label>
            <input wire:model="email" id="email" type="email" class="material-input" required autofocus autocomplete="email">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="material-group">
            <label class="material-label" for="password">Password</label>
            <input wire:model="password" id="password" type="password" class="material-input" required autocomplete="current-password" style="border-bottom: 2px solid #5cb85c;">
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled" class="btn-khybar">
            <span wire:loading.remove>LOGIN</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                LOGGING IN...
            </span>
        </button>

        <div class="mt-4 text-center">
            <p style="color: #888; margin-bottom: 15px;">Don't have an account?</p>
            <a href="{{ route('register') }}" class="btn-khybar-outline">CREATE NEW ACCOUNT</a>
        </div>
    </form>
</div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (!input) return;
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>


