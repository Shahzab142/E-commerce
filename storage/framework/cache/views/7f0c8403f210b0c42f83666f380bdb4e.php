

<?php $__env->startPush('title'); ?> <title><?php echo e(config('app.name', 'Shop Hub')); ?> | Quality Products Online</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('meta_description', 'Shop quality electronics, fashion, furniture, groceries, and more from trusted sellers at ' . config('app.name', 'Shop Hub') . '.'); ?>

<?php $__env->startSection('og_title', config('app.name', 'Shop Hub') . ' | Quality Products Online'); ?>

<?php $__env->startSection('content'); ?>


<?php echo $__env->make('partials.hero-slider', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<section class="py-4 bg-white border-bottom">

    <div class="container">

        <div class="row g-4 text-center">

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-center gap-3">

                    <div class="text-primary fs-1">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="text-start">
                        <div class="fw-bold fs-5">
                            <?php echo e($stats['productCount']); ?>+
                        </div>

                        <div class="text-muted small">
                            Products
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-center gap-3">

                    <div class="text-primary fs-1">
                        <i class="bi bi-bag-check"></i>
                    </div>

                    <div class="text-start">
                        <div class="fw-bold fs-5">
                            <?php echo e($stats['itemsSold']); ?>+
                        </div>

                        <div class="text-muted small">
                            Items Sold
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</section>



<?php echo $__env->make('layouts.top-deals-product', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<?php echo $__env->make('layouts.best-electronics', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<?php echo $__env->make('layouts.popular-category', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviews->isNotEmpty()): ?>

    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="shop-eyebrow">
                    Testimonials
                </span>

                <h2 class="shop-section-title">
                    What Our Customers Say
                </h2>

                <p class="shop-section-sub">
                    Real reviews from real shoppers
                </p>

            </div>

            <div class="row g-4">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                    <div class="col-lg-3 col-md-6">

                        <div class="card shop-review-card h-100 border-0 shadow-sm">

                            <div class="card-body p-4">

                                <div class="text-warning mb-2">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                                        <i class="bi <?php echo e($i <= ($review->rating ?? 5) ? 'bi-star-fill' : 'bi-star'); ?>"></i>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                </div>

                                <p class="text-secondary mb-3">
                                    "<?php echo e($review->comment ?? 'Great product!'); ?>"
                                </p>

                                <div class="d-flex align-items-center gap-2 mt-auto">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->user?->image): ?>

                                        <img
                                            src="<?php echo e(asset('storage/' . $review->user->image)); ?>"
                                            alt="<?php echo e($review->user->name); ?>"
                                            class="rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                        >

                                    <?php else: ?>

                                        <div class="shop-avatar">
                                            <?php echo e(substr($review->user->name ?? 'U', 0, 1)); ?>

                                        </div>

                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    <div>

                                        <div class="fw-semibold small">
                                            <?php echo e($review->user->name ?? 'Customer'); ?>

                                        </div>

                                        <small class="text-muted">
                                            <?php echo e($review->created_at?->format('M j, Y') ?? ''); ?>

                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            </div>

        </div>

    </section>

<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php echo $__env->make('layouts.recently-view', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\home.blade.php ENDPATH**/ ?>