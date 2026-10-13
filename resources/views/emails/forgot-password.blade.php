@component('components.email-layout')
    @slot('headerSubtitle')
        Account Security
    @endslot

    <h2>Reset Your Password</h2>
    <p>We received a request to reset the password for your <strong>{{ $appName ?? config('app.name', 'Shop Hub') }}</strong> account.</p>

    <p>Click the button below to choose a new password:</p>

    <a href="{{ $url }}" class="btn">Reset Password</a>

    <p>This password reset link will expire in <strong>60 minutes</strong>.</p>
    <p>If you did not request a password reset, you can safely ignore this email. Your password will not be changed.</p>

    Thanks,<br>
    <strong>{{ $appName ?? config('app.name', 'Shop Hub') }}</strong>
@endcomponent
