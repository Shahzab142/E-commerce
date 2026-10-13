<?php $__env->startPush('title'); ?>
    <title>Returns & Refunds - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Returns</span>
                <h1 class="display-5 fw-bold mb-3">Returns & Refunds</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Not satisfied with your purchase? No problem. Here's how our return process works.</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <h5 class="fw-bold mt-3">7-Day Window</h5>
                    <p class="text-muted small">Return items within 7 days of delivery</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-box"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Original Condition</h5>
                    <p class="text-muted small">Unused, with original packaging</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-arrow-return-left"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Free Return Label</h5>
                    <p class="text-muted small">We provide a prepaid return label</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Quick Refund</h5>
                    <p class="text-muted small">Refund processed within 5-7 days</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3">Return Policy</h3>
                        <p class="text-muted">We want you to love your purchase. If you're not satisfied, you may return most items within 7 days of delivery for a full refund or exchange. Items must be unused, in their original packaging, and in the same condition as received.</p>
                        <h3 class="fw-bold mt-4 mb-3">Non-Returnable Items</h3>
                        <p class="text-muted">Certain items cannot be returned, including perishable goods, personal care items, and items marked as final sale. Please check the product page for specific return eligibility.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\returns.blade.php ENDPATH**/ ?>