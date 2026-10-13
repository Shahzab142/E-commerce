<?php $__env->startPush('title'); ?>
    <title>Reviews - <?php echo e(config('app.name', 'E-Commerce')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Reviews</h1>
                        <p class="text-muted">Moderate product reviews.</p>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('status')): ?>
                        <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-outline-secondary">Clear Filter</a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Reviews</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['total']); ?></div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i class="bi bi-chat-left-text"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Approved</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['approved']); ?></div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i class="bi bi-patch-check"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Pending</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['pending']); ?></div>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i class="bi bi-hourglass-split"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Rejected</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['rejected']); ?></div>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3"><i class="bi bi-emoji-x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Review List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td><?php echo e($review->product?->name ?? '-'); ?></td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->user?->image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $review->user->image)); ?>"
                                                             alt="<?php echo e($review->user->name); ?>"
                                                             class="rounded-circle"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                             style="width: 32px; height: 32px; font-size: 0.75rem; font-weight: 600;">
                                                            <?php echo e(substr($review->user?->name ?? 'U', 0, 1)); ?>

                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php echo e($review->user?->name ?? '-'); ?>

                                                </div>
                                            </td>
                                            <td><?php echo e($review->rating); ?>/5</td>
                                            <td><?php echo e(Str::limit($review->comment, 60)); ?></td>
                                            <td>
                                                <form action="<?php echo e(route('admin.reviews.status', $review)); ?>" method="POST" class="d-flex align-items-center gap-2">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="approved" <?php if($review->status === 'approved'): echo 'selected'; endif; ?>>Approved</option>
                                                        <option value="pending" <?php if($review->status === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                                                        <option value="rejected" <?php if($review->status === 'rejected'): echo 'selected'; endif; ?>>Rejected</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="text-end">
                                                <?php echo e($review->created_at?->format('M d, Y')); ?>

                                                <form action="<?php echo e(route('admin.reviews.destroy', $review)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-2">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No reviews found.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviews->hasPages()): ?>
                    <div class="mt-4">
                        <?php echo e($reviews->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </main>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/reviews.blade.php ENDPATH**/ ?>