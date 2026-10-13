<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    #[Locked]
    public string $token = '';

    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($this->token === '') {
            $this->redirect(route('forgot-password'));
        }

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            Session::flash('status', 'password-reset-success');
            $this->redirectRoute('login');
        }
    }
};
?>

<div class="p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
            style="width: 56px; height: 56px;">
            <i class="bi bi-key-fill fs-3 text-primary"></i>
        </div>
        <h2 class="h4 fw-bold mb-2">Reset Your Password</h2>
        <p class="text-muted small">
            Enter your new password below to regain access to your account.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ __('passwords.' . session('status')) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
    <label for="password" class="form-label fw-medium">
        New Password
    </label>

    <div class="position-relative">
        <input
            id="password"
            type="password"
            name="password"
            required
            autocomplete="new-password"
            placeholder="Create a new password"
            class="form-control pe-5"
        >

        <button
            type="button"
            onclick="togglePassword('password', this)"
            aria-label="Toggle password visibility"
            class="position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent text-muted d-flex align-items-center justify-content-center"
            style="width: 24px; height: 24px;"
        >
            <i class="bi bi-eye fs-5"></i>
        </button>
    </div>

    @error('password')
        <div class="invalid-feedback d-block text-danger small mt-1">
            {{ $message }}
        </div>
    @enderror
</div>

<div class="mb-3">
    <label for="password_confirmation" class="form-label fw-medium">
        Confirm New Password
    </label>

    <div class="position-relative">
        <input
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            required
            autocomplete="new-password"
            placeholder="Confirm your new password"
            class="form-control pe-5"
        >

        <button
            type="button"
            onclick="togglePassword('password_confirmation', this)"
            aria-label="Toggle password visibility"
            class="position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent text-muted d-flex align-items-center justify-content-center"
            style="width: 24px; height: 24px;"
        >
            <i class="bi bi-eye fs-5"></i>
        </button>
    </div>
</div>

        <button type="submit" class="btn btn-primary w-100 py-2 mt-1">
            Reset Password
        </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top">
        <p class="small text-muted mb-0">
            <a href="{{ route('login') }}" wire:navigate class="text-decoration-none">
                &larr; Back to Sign In
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
