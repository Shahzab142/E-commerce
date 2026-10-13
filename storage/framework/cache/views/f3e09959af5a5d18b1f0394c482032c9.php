

<?php $__env->startPush('title'); ?>
    <title><?php echo e($prod->name); ?> - Product Detail</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">

        <main>

            
            <div class="container-fluid bg-light py-5 border-bottom">

                <div class="container text-center">

                    <h1 class="display-5 fw-bold">

                        <i class="bi bi-card-text text-primary me-2"></i>

                        Product Detail

                    </h1>

                    <p class="text-muted">
                        Product Information
                    </p>

                </div>

            </div>


            
            <section class="py-5">

                <div class="container">

                    <div class="card border-0 shadow-lg rounded-4">

                        <div class="row g-0">


                            
                            <div class="col-lg-5">

                                <div class="p-4">

                                    <?php
                                        $productImage = $prod->images->first();
                                    ?>


                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productImage): ?>
                                        <img src="<?php echo e(asset('storage/' . $productImage->image)); ?>"
                                            class="img-fluid rounded-4 w-100" alt="<?php echo e($prod->name); ?>">
                                    <?php else: ?>
                                        <div class="text-center text-muted py-5">

                                            <i class="bi bi-image fs-1"></i>

                                            <p class="mt-2">
                                                No Image Available
                                            </p>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </div>

                            </div>


                            
                            <div class="col-lg-7">

                                <div class="card-body p-4 p-lg-5">


                                    
                                    <h2 class="fw-bold mt-3">

                                        <?php echo e($prod->name); ?>


                                    </h2>


                                    
                                    <div class="mb-3">

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->status == 'published'): ?>
                                            <span class="badge bg-success">
                                                Published
                                            </span>
                                        <?php elseif($prod->status == 'draft'): ?>
                                            <span class="badge bg-secondary">
                                                Draft
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                Hidden
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </div>


                                    
                                    <h3 class="text-danger fw-bold">

                                        Rs.
                                        <?php echo e(number_format($prod->sale_price ?? $prod->regular_price, 2)); ?>



                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->sale_price): ?>
                                            <small class="text-muted text-decoration-line-through fs-5 ms-2">

                                                Rs.
                                                <?php echo e(number_format($prod->regular_price, 2)); ?>


                                            </small>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                    </h3>


                                    <hr>


                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->short_description): ?>
                                        <p class="text-muted">

                                            <?php echo e($prod->short_description); ?>


                                        </p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                    
                                    <div class="row mt-4">


                                        
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Category
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                <?php echo e($prod->category->name ?? 'No Category'); ?>


                                            </p>

                                        </div>


                                        
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Availability
                                            </strong>

                                            <div>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->stock_status == 'in_stock'): ?>
                                                    <span class="badge bg-success">
                                                        In Stock
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">
                                                        Out of Stock
                                                    </span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                            </div>

                                        </div>


                                        
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                SKU
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                <?php echo e($prod->sku); ?>


                                            </p>

                                        </div>


                                        
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Barcode
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                <?php echo e($prod->barcode ?? 'N/A'); ?>


                                            </p>

                                        </div>


                                        
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Quantity
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                <?php echo e($prod->quantity); ?>


                                            </p>

                                        </div>

                                    </div>


                                    <hr>


                                    
                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="<?php echo e(url('admin/edit-product/' . $prod->id)); ?>" class="btn btn-warning">

                                            <i class="bi bi-pencil-square me-1"></i>

                                            Edit Product

                                        </a>


                                        <a href="<?php echo e(url('admin/view-product')); ?>" class="btn btn-secondary">

                                            <i class="bi bi-arrow-left me-1"></i>

                                            Back to Products

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>


                        

                        <div class="p-4 p-lg-5 border-top">

                            <h3 class="fw-bold">
                                About Product
                            </h3>

                            <p class="text-muted mt-3">

                                <?php echo e($prod->description); ?>


                            </p>

                        </div>


                    </div>

                </div>

            </section>

        </main>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/show-product.blade.php ENDPATH**/ ?>