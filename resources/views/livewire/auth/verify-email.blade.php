<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public function mount(): void
    {
        if (Auth::user()?->email_verified_at) {
            $this->redirectIntended(default: route('dashboard'), navigate: true);
        }
    }

    public function sendVerification(): void
    {
        $user = Auth::user();

        if (! $user) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        if ($user->email_verified_at) {
            $this->redirectIntended(default: route('dashboard'), navigate: true);
            return;
        }

        \App\Services\VerificationCodeService::generateAndSend($user->email);

        Session::flash('status', 'A fresh verification code has been sent to your email address.');
    }

    public function goToVerifyCode(): void
    {
        $this->redirectRoute('verification.verify-code', navigate: true);
    }

    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

<div class="p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
            style="width: 56px; height: 56px;">
            <i class="bi bi-envelope-check fs-3 text-primary"></i>
        </div>
        <h2 class="h4 fw-bold mb-2">Verify Your Email Address</h2>
        <p class="text-muted small">
            Before you can access your account, please verify your email address
            by clicking the button below.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form wire:submit="sendVerification">
        <button type="submit" wire:loading.attr="disabled"
            class="btn btn-primary w-100 py-2 mb-3">
            <span wire:loading.remove>Resend Verification Code</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Sending...
            </span>
        </button>
    </form>

    <div class="text-center mb-4">
        <button type="button" wire:click="goToVerifyCode" class="btn btn-outline-primary w-100 py-2">
            Enter Verification Code
        </button>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 small">
        <a href="{{ route('login') }}" wire:navigate class="text-decoration-none">
            &larr; Back to Sign In
        </a>

        <form wire:submit="logout">
            <button type="submit" class="btn btn-link text-decoration-none small">
                Sign Out
            </button>
        </form>
    </div>
</div>
