<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product', 'showBadge' => true, 'wishlistIds' => []]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product', 'showBadge' => true, 'wishlistIds' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
    $currentPrice = $product->currentPrice();
    $discount = $product->discountPercent();
    $rating = $product->averageRating();
    $reviewCount = $product->approvedReviews->count();
    $isInWishlist = isset($wishlistIds[$product->id]);
    $vendor = null;
?>

<div class="product-card h-100">
    <div class="product-image">
        <a href="<?php echo e(route('product.detail', $product->id)); ?>" class="d-block text-decoration-none">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image): ?>
                <img src="<?php echo e(asset('storage/' . $image->image)); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                    <i class="bi bi-image fs-1 text-muted"></i>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </a>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="mt-1">
            <a href="<?php echo e(route('product.detail', $product->id)); ?>" class="text-decoration-none product-name" title="<?php echo e($product->name); ?>">
                <?php echo e($product->name); ?>

            </a>
        </h5>

        <div class="mt-auto">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount > 0): ?>
                <div class="price-current">Rs. <?php echo e(number_format($currentPrice, 0)); ?></div>
                <div class="price-row mt-1">
                    <span class="price-regular">Rs. <?php echo e(number_format((float) $product->regular_price, 0)); ?></span>
                    <span class="price-off">-<?php echo e($discount); ?>%</span>
                </div>
            <?php else: ?>
                <div class="price-current">Rs. <?php echo e(number_format($currentPrice, 0)); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rating > 0): ?>
                <div class="rating-stars mt-1">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= floor($rating)): ?>
                            <i class="bi bi-star-fill"></i>
                        <?php elseif($i - 0.5 <= $rating): ?>
                            <i class="bi bi-star-half"></i>
                        <?php else: ?>
                            <i class="bi bi-star"></i>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <span class="text-muted" style="font-size: 0.7rem;">(<?php echo e($reviewCount); ?>)</span>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\components\product-card.blade.php ENDPATH**/ ?>