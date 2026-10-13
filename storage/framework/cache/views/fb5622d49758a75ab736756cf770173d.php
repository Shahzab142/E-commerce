<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

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

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->isInStock()): ?>
<div class="subscribe-save-card mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="subscribe-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Subscribe & Save</h6>
                    <p class="text-muted small mb-0">Get 10% off + free shipping on regular deliveries</p>
                </div>
            </div>
            <div class="subscription-options">
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-none" value="none" checked>
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-none">
                        <span>One-time purchase</span>
                        <span class="fw-bold">$<?php echo e(number_format($product->currentPrice(), 2)); ?></span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-weekly" value="weekly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-weekly">
                        <span>Every week</span>
                        <span>
                            <span class="fw-bold text-success">$<?php echo e(number_format($product->currentPrice() * 0.9, 2)); ?></span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-monthly" value="monthly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-monthly">
                        <span>Every month</span>
                        <span>
                            <span class="fw-bold text-success">$<?php echo e(number_format($product->currentPrice() * 0.9, 2)); ?></span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-bimonthly" value="bimonthly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-bimonthly">
                        <span>Every 2 months</span>
                        <span>
                            <span class="fw-bold text-success">$<?php echo e(number_format($product->currentPrice() * 0.9, 2)); ?></span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
            </div>
            <p class="text-muted small mt-2 mb-0">
                <i class="bi bi-info-circle me-1"></i>Cancel anytime. No commitment required.
            </p>
        </div>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<style>
    .subscribe-save-card .form-check-input {
        display: none;
    }
    .subscription-option {
        padding: 0.75rem 1rem;
        border: 2px solid var(--shop-gray-200);
        border-radius: var(--shop-radius);
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .subscription-option:hover {
        border-color: var(--shop-primary);
    }
    .subscription-option:has(input:checked) {
        border-color: var(--shop-green);
        background: var(--shop-green-soft);
    }
    .subscribe-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--shop-green-soft);
        color: var(--shop-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\layouts\subscribe-save.blade.php ENDPATH**/ ?>