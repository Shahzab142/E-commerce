

<?php $__env->startPush('title'); ?>
    <title><?php echo e($category->name); ?> - View Category</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h2 class="fw-bold mb-1">

                            <i class="bi bi-eye me-2 text-primary"></i>

                            View Category

                        </h2>

                        <p class="text-muted mb-0">
                            View the complete details of this category.
                        </p>

                    </div>

                    <div class="d-flex gap-2">

                        <a href="<?php echo e(route('admin.categories.view')); ?>" class="btn btn-outline-secondary">

                            <i class="bi bi-arrow-left me-1"></i>

                            Back to Categories

                        </a>

                        <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-primary">

                            <i class="bi bi-pencil-square me-1"></i>

                            Edit Category

                        </a>

                    </div>

                </div>


                
                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white py-3">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-info-circle text-primary me-2"></i>

                            Category Details

                        </h5>

                    </div>


                    <div class="card-body">

                        <div class="row g-4">

                            
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Category Name
                                </label>

                                <div class="form-control bg-light">

                                    <?php echo e($category->name); ?>


                                </div>

                            </div>


                            
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Category ID
                                </label>

                                <div class="form-control bg-light">

                                    <?php echo e($category->id); ?>


                                </div>

                            </div>


                            
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Slug
                                </label>

                                <div class="form-control bg-light">

                                    <?php echo e($category->slug); ?>


                                </div>

                            </div>


                            
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Status
                                </label>

                                <div>

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->status === 'published'): ?>
                                        <span class="badge bg-success fs-6">
                                            Published
                                        </span>
                                    <?php elseif($category->status === 'draft'): ?>
                                        <span class="badge bg-warning text-dark fs-6">
                                            Draft
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary fs-6">
                                            Hidden
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </div>

                            </div>


                            
                            <div class="col-12">

                                <label class="fw-bold text-muted">
                                    Short Description
                                </label>

                                <div class="border rounded p-3 bg-light">

                                    <?php echo e($category->short_description ?? 'No short description available.'); ?>


                                </div>

                            </div>


                            
                            <div class="col-12">

                                <label class="fw-bold text-muted">
                                    Full Description
                                </label>

                                <div class="border rounded p-3 bg-light">

                                    <?php echo nl2br(e($category->description ?? 'No description available.')); ?>


                                </div>

                            </div>


                            
                            <div class="col-md-6">

                                <label class="fw-bold text-muted">
                                    Show on Homepage
                                </label>

                                <div class="mt-1">

                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->show_on_homepage): ?>
                                        <span class="badge bg-success fs-6">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Yes

                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary fs-6">

                                            <i class="bi bi-x-circle me-1"></i>

                                            No

                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>


                    
                    <div class="card-footer bg-white">

                        <div class="d-flex justify-content-end gap-2">

                            <a href="<?php echo e(route('admin.categories.view')); ?>" class="btn btn-outline-secondary">

                                <i class="bi bi-arrow-left me-1"></i>

                                Back

                            </a>

                            <a href="<?php echo e(route('admin.categories.edit', $category->id)); ?>" class="btn btn-primary">

                                <i class="bi bi-pencil-square me-1"></i>

                                Edit Category

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </main>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\show-category.blade.php ENDPATH**/ ?>