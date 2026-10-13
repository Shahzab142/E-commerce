<?php $__env->startPush('title'); ?>
    <title>About Us - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Our Story</span>
                <h1 class="display-5 fw-bold mb-3">About <?php echo e(config('app.name', 'Shop Hub')); ?></h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Your trusted online marketplace for quality products and exceptional service.</p>
            </div>
        </div>

        <div class="row gy-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Fast Delivery</h5>
                    <p class="text-muted small">We deliver your orders quickly and safely to your doorstep with real-time tracking.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Secure Payment</h5>
                    <p class="text-muted small">Your payments are processed securely with industry-standard encryption and multiple payment options.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h5 class="fw-bold mt-3">24/7 Support</h5>
                    <p class="text-muted small">Our support team is always available to assist you with any questions or concerns.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminDetails): ?>
                            <h3 class="fw-bold mb-3">Welcome to <?php echo e($adminDetails->user?->name ?? config('app.name')); ?></h3>
                            <p class="text-muted">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminDetails->address): ?>
                                    Located at <?php echo e($adminDetails->address); ?>, we are committed to delivering quality products from trusted vendors directly to your doorstep.
                                <?php else: ?>
                                    We are committed to delivering quality products from trusted vendors directly to your doorstep.
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                            <p class="text-muted">
                                Our mission is to provide you with the best shopping experience, from discovery to delivery.
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminDetails->easypaisa_number || $adminDetails->jazzcash_number || $adminDetails->bank_name): ?>
                                    We support multiple payment methods including Easypaisa, Jazzcash, and Bank transfers for your convenience.
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        <?php else: ?>
                            <h3 class="fw-bold mb-3">Welcome to <?php echo e(config('app.name', 'Shop Hub')); ?></h3>
                            <p class="text-muted">
                                We are a leading e-commerce platform dedicated to providing you with the best online shopping experience.
                                Our mission is to connect buyers with trusted sellers and offer a wide variety of high-quality products at competitive prices.
                            </p>
                            <p class="text-muted">
                                From electronics to fashion, furniture to groceries, we have everything you need in one place.
                                Shop with confidence and enjoy fast delivery, secure payments, and dedicated customer support.
                            </p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\about.blade.php ENDPATH**/ ?>