<?php

use App\Mail\VerificationCodeEmail;
use App\Services\VerificationCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $code = '';

    public function mount(): void
    {
        $email = Session::get('verification_email');

        if (! $email && Auth::check()) {
            $email = Auth::user()->email;
            Session::put('verification_email', $email);
        }

        if (! $email) {
            $this->redirectRoute('login', navigate: true);
        }
    }

    public function verify(): void
    {
        $this->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $email = Session::get('verification_email');

        if (! $email) {
            $this->addError('code', 'Verification session expired. Please try signing up again.');
            return;
        }

        $service = app(VerificationCodeService::class);
        $result = $service->validate($email, trim($this->code));

        if (! $result['valid']) {
            $this->addError('code', $result['message']);
            return;
        }

        $service->markVerified($email);
        $service->delete($email);

        $user = \App\Models\User::where('email', $email)->first();

        if ($user) {
            $user->forceFill([
                'status' => \App\Models\User::STATUS_ACTIVE,
                'email_verified_at' => now(),
                'login_verified_at' => now(),
            ])->save();

            Session::forget(['verification_email', 'verification_context', 'login_credentials']);

            Auth::login($user);

            $intended = session()->pull('url.intended', route($user->dashboardRoute()));

            \Illuminate\Support\Facades\Log::info("Verification completed for {$email}. Intended URL: {$intended}");

            if (str_contains($intended, 'verify-code')) {
                $intended = route($user->dashboardRoute());
            }

            $this->redirect($intended, navigate: true);
        } else {
            $this->addError('code', 'User not found. Please try signing up again.');
        }
    }

    public function resend(): void
    {
        $email = Session::get('verification_email');

        if (! $email && Auth::check()) {
            $email = Auth::user()->email;
            Session::put('verification_email', $email);
        }

        if (! $email) {
            $this->redirectRoute('login', navigate: true);
            return;
        }

        $service = app(VerificationCodeService::class);
        $service->delete($email);

        $result = $service->generate($email);

        try {
            Mail::to($email)->send(
                new VerificationCodeEmail(
                    $result['code'],
                    $result['expires_at']->format('g:i A'),
                    Session::get('verification_context', 'signup')
                )
            );

            if (app()->environment('local')) {
                Session::flash('status', "A new verification code has been sent. Local Dev Code: {$result['code']}");
            } else {
                Session::flash('status', 'A new verification code has been sent to your email.');
            }
        } catch (\Exception $e) {
            if (app()->environment('local')) {
                Session::flash('error', "Failed to send email. Local Dev Code: {$result['code']}");
            } else {
                Session::flash('error', 'Failed to send verification code. Please try again.');
            }
        }
    }
};
?>

<div class="p-4 p-md-5">
    <div class="text-center mb-4">
        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
            style="width: 56px; height: 56px;">
            <i class="bi bi-shield-check fs-3 text-primary"></i>
        </div>
        <h2 class="h4 fw-bold mb-2">Verify Your Email</h2>
        <p class="text-muted small">
            We sent a 6-digit verification code to your email address.
            Please enter it below to verify your account.
        </p>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form wire:submit="verify">
        <div class="mb-3">
            <label for="code" class="form-label fw-medium">Verification Code</label>
            <input
                wire:model="code"
                id="code"
                type="text"
                inputmode="numeric"
                maxlength="6"
                autocomplete="one-time-code"
                placeholder="Enter 6-digit code"
                class="form-control form-control-lg text-center"
                style="letter-spacing: 0.5rem; font-size: 1.5rem;"
                required
                autofocus
            >
            @error('code')
                <div class="invalid-feedback d-block text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="btn btn-primary btn-lg w-100 py-2 rounded-3 fw-semibold mt-2">
            <span wire:loading.remove>Verify Email</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                Verifying...
            </span>
        </button>
    </form>

    <div class="text-center mt-3">
        <button type="button" wire:click="resend" wire:loading.attr="disabled"
            class="btn btn-link text-decoration-none small text-primary fw-medium">
            Didn't receive the code? Resend
        </button>
    </div>

    <div class="text-center mt-4 pt-3 border-top">
        <p class="small text-muted mb-0">
            <a href="{{ route('login') }}" wire:navigate class="text-decoration-none text-primary fw-medium">
                &larr; Back to Sign In
            </a>
        </p>
    </div>
</div>



