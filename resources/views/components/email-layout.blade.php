@php
    $appName = config('app.name', 'Shop Hub');
    $primaryColor = '#4f46e5';
    $secondaryColor = '#6366f1';
    $gradientStart = '#4f46e5';
    $gradientEnd = '#6366f1';
    $bgColor = '#f8fafc';
    $textColor = '#1e293b';
    $mutedColor = '#64748b';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? $appName }}</title>
    <style>
        body { font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; background: {{ $bgColor }}; margin: 0; padding: 20px; -webkit-font-smoothing: antialiased; }
        .email-container { max-width: 640px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .email-header { background: linear-gradient(135deg, {{ $gradientStart }}, {{ $gradientEnd }}); padding: 36px 30px; text-align: center; color: #ffffff; position: relative; overflow: hidden; }
        .email-header::after { content: ''; position: absolute; top: -50%; right: -20%; width: 200px; height: 200px; background: rgba(255,255,255,0.12); border-radius: 50%; pointer-events: none; }
        .email-header h1 { margin: 0; font-size: 26px; font-weight: 700; letter-spacing: -0.3px; }
        .email-header p { margin: 6px 0 0; opacity: 0.92; font-size: 15px; }
        .email-body { padding: 32px 30px; color: {{ $textColor }}; font-size: 15px; line-height: 1.7; }
        .email-body h2 { font-size: 20px; font-weight: 700; margin: 24px 0 12px; color: {{ $textColor }}; }
        .email-body p { margin: 0 0 14px; color: {{ $mutedColor }}; }
        .email-body strong { color: {{ $textColor }}; font-weight: 600; }
        .btn { display: inline-block; padding: 14px 28px; background: linear-gradient(135deg, {{ $gradientStart }}, {{ $gradientEnd }}); color: #ffffff; text-decoration: none; border-radius: 10px; font-weight: 600; font-size: 15px; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3); margin: 22px 0; }
        .card { background: {{ $bgColor }}; border-radius: 12px; padding: 18px 20px; margin: 14px 0; border: 1px solid #e2e8f0; }
        .info-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #e2e8f0; }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: {{ $mutedColor }}; font-size: 14px; }
        .info-value { font-weight: 600; color: {{ $textColor }}; font-size: 14px; text-align: right; max-width: 60%; }
        .badge { display: inline-block; padding: 4px 12px; background: #eef2ff; color: {{ $primaryColor }}; border-radius: 999px; font-size: 13px; font-weight: 600; }
        .email-footer { background: #f1f5f9; padding: 22px 30px; text-align: center; font-size: 13px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        .email-footer a { color: {{ $primaryColor }}; text-decoration: none; font-weight: 600; }
        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 22px 0; }
        .section-title { font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: {{ $mutedColor }}; font-weight: 700; margin-bottom: 8px; }
        .code-box { text-align: center; margin: 24px 0; font-size: 32px; font-weight: 800; letter-spacing: 6px; background: linear-gradient(135deg, #eef2ff, #e0e7ff); padding: 22px; border-radius: 12px; color: {{ $primaryColor }}; border: 1px dashed #c7d2fe; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $appName }}</h1>
            @isset($headerSubtitle)
                <p>{{ $headerSubtitle }}</p>
            @endisset
        </div>
        <div class="email-body">
            {{ $slot }}
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ $appName }}</a>. All rights reserved.<br>
            <span style="margin-top: 6px; display: block;">Sent with love. Need help? <a href="{{ url('/contact') }}">Contact us</a></span>
        </div>
    </div>
</body>
</html>
