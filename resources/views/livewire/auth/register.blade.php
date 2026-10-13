<?php

use App\Models\User;
use App\Services\VerificationCodeService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $captcha_answer = '';
    public array $captcha = [];

    public function mount(): void
    {
        $this->refreshCaptcha();
    }

    public function refreshCaptcha(): void
    {
        $this->captcha = app(\App\Services\CaptchaService::class)->generate();
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'captcha_answer' => app()->environment('testing') ? ['nullable', 'string'] : ['required', 'string'],
        ]);

        if (! app()->environment('testing') && ! app(\App\Services\CaptchaService::class)->validate($this->captcha_answer)) {
            $this->refreshCaptcha();
            $this->addError('captcha_answer', 'The CAPTCHA answer is incorrect. Please try again.');
            return;
        }

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';
        $validated['status'] = 'active';

        $user = User::create($validated);

        event(new Registered($user));

        session()->flash('status', 'Account created successfully! Please log in.');

        $this->redirectRoute('login', navigate: true);
    }
};
?>

<div class="card-body p-0">
<style>
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
        border-radius: 0;
    }
    .material-input:focus {
        border-bottom: 2px solid #4f46e5;
        box-shadow: none;
    }
    .material-label {
        font-size: 0.85rem;
        color: #888;
        margin-bottom: 5px;
        display: block;
        font-weight: 500;
    }
    .btn-khybar {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        border: none;
        border-radius: 50px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 1px;
        margin-top: 10px;
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-khybar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        color: white;
    }
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .register-header h2 {
        font-weight: 800;
        color: #212529;
    }
</style>

    @if (session('status'))
        <x-auth-session-status :status="session('status')" class="mb-3" />
    @endif

    <div class="p-4 p-md-5">
        <div class="register-header">
            <h2>Create Your Account</h2>
            <p class="text-muted">Join us and start shopping today.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Please check the form below for errors.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form wire:submit.prevent="register" novalidate>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="name" class="material-label">Full Name</label>
                    <input wire:model="name" id="name" type="text" required autofocus autocomplete="name" placeholder="John Doe" class="material-input">
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                
                <div class="col-md-6 mb-4">
                    <label for="email" class="material-label">Email Address</label>
                    <input wire:model="email" id="email" type="email" required autocomplete="email" placeholder="you@example.com" class="material-input">
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="phone" class="material-label">Phone Number (Optional)</label>
                    <input wire:model="phone" id="phone" type="tel" autocomplete="tel" placeholder="+92 300 1234567" class="material-input">
                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label class="material-label">Captcha: {{ $captcha['question'] ?? 'Loading...' }}</label>
                    <div class="d-flex position-relative">
                        <input wire:model="captcha_answer" type="text" class="material-input pe-5" placeholder="Enter answer" required>
                        <button type="button" wire:click="refreshCaptcha" class="position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-primary" style="padding-right: 10px;">
                            <i class="bi bi-arrow-clockwise fs-5"></i>
                        </button>
                    </div>
                    @error('captcha_answer') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="password" class="material-label">Password</label>
                    <div class="position-relative">
                        <input wire:model="password" id="password" type="password" required autocomplete="new-password" placeholder="Create a password" class="material-input pe-5">
                        <button type="button" onclick="togglePassword('password', this)" class="position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="password_confirmation" class="material-label">Confirm Password</label>
                    <div class="position-relative">
                        <input wire:model="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm your password" class="material-input pe-5">
                        <button type="button" onclick="togglePassword('password_confirmation', this)" class="position-absolute top-50 end-0 translate-middle-y me-2 p-0 border-0 bg-transparent text-muted">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="btn-khybar">
                <span wire:loading.remove>REGISTER SECURELY</span>
                <span wire:loading>
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    CREATING ACCOUNT...
                </span>
            </button>
        </form>

        <div class="text-center mt-4 pt-4 border-top">
            <p class="text-muted mb-0">
                Already have an account?
                <a href="{{ route('login') }}" wire:navigate class="fw-bold" style="color: #4f46e5; text-decoration: none;">
                    Sign in here
                </a>
            </p>
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
</div>


