@php
    $siteLogoName    = config('app.name', 'Shop Hub');
    $siteLogoVariant = $variant ?? 'mark';
    $siteLogoMark    = $markClass ?? ($siteLogoVariant === 'large' ? 'shop-auth-brand-mark' : 'shop-logo-mark');
    $siteLogoUrl     = 'assets/images/logo.png';

    foreach (['png', 'svg', 'jpg', 'jpeg', 'webp'] as $siteLogoExt) {
        $siteLogoCandidate = 'assets/images/logo.' . $siteLogoExt;
        if (is_file(public_path($siteLogoCandidate))) {
            $siteLogoUrl = asset($siteLogoCandidate);
            break;
        }
    }
@endphp
@if ($siteLogoUrl)
    <img src="{{ $siteLogoUrl }}"
         alt="{{ $siteLogoName }}"
         class="brand-logo-img{{ $siteLogoVariant === 'large' ? ' brand-logo-img-lg' : '' }}">
@elseif ($siteLogoVariant === 'large')
    <i class="bi bi-shop display-1 opacity-75"></i>
@else
    <span class="{{ $siteLogoMark }}">
        <i class="bi bi-shop"></i>
    </span>
@endif
