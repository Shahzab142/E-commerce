<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $password = '';

    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (
            !Auth::guard('web')->validate([
                'email' => Auth::user()->email,
                'password' => $this->password,
            ])
        ) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
};
?>

<div class="p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
            style="width: 56px; height: 56px;">
            <i class="bi bi-shield-lock fs-3 text-primary"></i>
        </div>
        <h2 class="h4 fw-bold mb-2">Confirm Your Password</h2>
        <p class="text-muted small">
            For your security, please confirm your password before continuing.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit="confirmPassword">
        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password</label>
            <input
                wire:model="password"
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="Enter your password"
                class="form-control"
            >
            @error('password')
                <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="btn btn-primary w-100 py-2 mt-1">
            <span wire:loading.remove>Confirm Password</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Confirming...
            </span>
        </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top">
        <a href="{{ route('login') }}" wire:navigate class="text-decoration-none small">
            &larr; Back to Sign In
        </a>
    </div>
</div>
