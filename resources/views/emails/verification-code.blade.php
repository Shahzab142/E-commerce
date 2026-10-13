@component('components.email-layout')
    @slot('headerSubtitle')
        Secure Verification
    @endslot

    <h2>Your Verification Code</h2>
    <p>Hello, please use the verification code below {{ $context === 'signup' ? 'to complete your sign-up' : 'to proceed with your request' }}:</p>

    <div class="code-box">
        {{ $code }}
    </div>

    <p>This code will expire in <strong>{{ $expiresAt }}</strong>. If you did not request this code, you can safely ignore this email.</p>

    @if($context === 'reset')
        <a href="{{ url('reset-password') }}" class="btn">Reset Password</a>
    @endif

    Thanks,<br>
    <strong>{{ $appName ?? 'Shop Hub' }}</strong>
@endcomponent
