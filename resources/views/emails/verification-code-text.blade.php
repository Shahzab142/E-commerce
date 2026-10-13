{{ $appName ?? 'Shop Hub' }} - Verification Code

Hello,

Your verification code is: {{ $code }}

This code will expire in {{ $expiresAt }}.

Context: {{ $context === 'signup' ? 'Sign-up verification' : 'Other' }}

If you did not request this code, simply ignore this email.

Thanks,
{{ $appName ?? 'The Team' }}
