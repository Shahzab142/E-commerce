<?php
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
?>
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($siteLogoUrl): ?>
    <img src="<?php echo e($siteLogoUrl); ?>"
         alt="<?php echo e($siteLogoName); ?>"
         class="brand-logo-img<?php echo e($siteLogoVariant === 'large' ? ' brand-logo-img-lg' : ''); ?>">
<?php elseif($siteLogoVariant === 'large'): ?>
    <i class="bi bi-shop display-1 opacity-75"></i>
<?php else: ?>
    <span class="<?php echo e($siteLogoMark); ?>">
        <i class="bi bi-shop"></i>
    </span>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\partials\site-logo.blade.php ENDPATH**/ ?>