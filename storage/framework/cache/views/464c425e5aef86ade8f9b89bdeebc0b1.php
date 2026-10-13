<?php $__env->startPush('title'); ?>
    <title><?php echo e($category->name); ?> | <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('meta_description', $category->short_description ?: 'Shop ' . $category->name . ' products at ' .
    config('app.name', 'Shop Hub') . '.'); ?>

<?php $__env->startSection('content'); ?>
    <main class="container py-5">
        <header class="mb-4">
            <p class="text-uppercase text-primary fw-semibold mb-1">Collection</p>
            <h1 class="fw-bold"><?php echo e($category->name); ?></h1>
            <p class="text-muted"><?php echo e($category->description ?: $category->short_description); ?></p>
        </header>
        <div class="row g-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $image = $product->images->first();
                    $price = $product->sale_price ?? $product->regular_price;
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <article class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-image">
                            <img src="<?php echo e($image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg')); ?>"
                                class="card-img-top" alt="<?php echo e($product->name); ?>">
                            <a href="<?php echo e(url('/product/' . $product->id)); ?>" class="btn btn-light btn-sm" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo e($image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg')); ?>" download class="btn btn-light btn-sm ms-1" title="Download Image">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold"><?php echo e($product->name); ?></h5>
                            <p class="text-muted small flex-grow-1"><?php echo e($product->short_description); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong class="text-danger">$<?php echo e(number_format((float) $price, 2)); ?></strong>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="navigator.clipboard.writeText('Name: <?php echo e($product->name); ?>\nPrice: $<?php echo e(number_format((float) $price, 2)); ?>\n<?php echo e($product->short_description); ?>'); alert('Details Copied!');">
                                        <i class="bi bi-clipboard me-1"></i>Copy Details
                                    </button>
                                    <form action="<?php echo e(route('user.reserve', $product->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill">
                                            <i class="bi bi-bookmark me-1"></i>Reserve
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <div class="col-12">
                    <p class="text-muted text-center py-5">No published products are available in this category.</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/category.blade.php ENDPATH**/ ?>