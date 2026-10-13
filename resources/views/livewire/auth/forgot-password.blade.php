<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'email'],
        ]);

        Password::sendResetLink([
            'email' => $this->email,
        ]);

        session()->flash('status', __('A reset link will be sent if the account exists.'));
    }
};
?>

<div class="p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
            style="width: 56px; height: 56px;">
            <i class="bi bi-shield-lock fs-3 text-primary"></i>
        </div>
        <h2 class="h4 fw-bold mb-2">Forgot your password?</h2>
        <p class="text-muted small mx-auto mb-0" style="max-width: 420px;">
            No worries. Enter the email address associated with your account and
            we'll send you a secure password reset link.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="alert alert-info border-0 rounded-3 small mb-3" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        We'll send a password reset link to your registered email address.
    </div>

    <form wire:submit="sendPasswordResetLink">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email Address</label>
            <input
                wire:model="email"
                id="email"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="email"
                placeholder="you@example.com"
                class="form-control form-control-lg"
                value="{{ old('email') }}"
            >
            @error('email')
                <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="btn btn-primary btn-lg w-100 py-2 rounded-3 fw-semibold mt-1">
            <span wire:loading.remove>Send Reset Link</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Sending...
            </span>
        </button>
    </form>

    <div class="text-center mt-4 pt-3 border-top">
        <p class="small text-muted mb-0">
            <a href="{{ route('login') }}" wire:navigate class="text-decoration-none text-primary fw-medium">
                &larr; Back to Sign In
            </a>
        </p>
    </div>
</div>
