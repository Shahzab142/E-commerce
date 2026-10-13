<?php $__env->startPush('title'); ?>
    <title>Activity Log - <?php echo e(config('app.name', 'E-Commerce')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Activity Log</h1>
                        <p class="text-muted">All system activity and audit trail.</p>
                    </div>
                    <form method="GET" action="<?php echo e(route('admin.activity')); ?>" class="d-flex gap-2">
                        <select name="actor" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                            <option value="">All Actors</option>
                            <option value="admin" <?php echo e(request('actor') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                            <option value="employee" <?php echo e(request('actor') === 'employee' ? 'selected' : ''); ?>>Employee</option>
                            <option value="vendor" <?php echo e(request('actor') === 'vendor' ? 'selected' : ''); ?>>Vendor</option>
                        </select>
                    </form>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Logs</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['total']); ?></div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i class="bi bi-file-text"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Admin Actions</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['admin']); ?></div>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3"><i class="bi bi-person-gear"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Employee Actions</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['employee'] ?? $stats['vendor'] ?? 0); ?></div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i class="bi bi-person-badge"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Today</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['today']); ?></div>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i class="bi bi-today"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Recent Activity (<?php echo e($logs->total()); ?>)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Actor</th>
                                        <th>Action</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="text-muted small"><?php echo e($log->created_at?->format('M d, Y H:i')); ?></td>
                                            <td>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->actor): ?>
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                            <?php echo e(mb_substr($log->actor->name ?? '?', 0, 2)); ?>

                                                        </div>
                                                        <?php echo e($log->actor->name ?? '-'); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted">System</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-<?php echo e($log->actor_type === 'vendor' ? 'warning' : 'primary'); ?>-subtle text-<?php echo e($log->actor_type === 'vendor' ? 'warning' : 'primary'); ?>">
                                                    <?php echo e(ucfirst($log->actor_type ?? 'system')); ?>

                                                </span>
                                                <div class="small text-muted mt-1"><?php echo e(str_replace('.', ' ', $log->action ?? '-')); ?></div>
                                            </td>
                                            <td><?php echo e($log->description ?? '-'); ?></td>
                                            <td class="text-end">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($log->actor_type === 'vendor' && $log->subject_type === \App\Models\User::class && in_array($log->action, [\App\Models\ActivityLog::ACTION_USER_BLOCKED, \App\Models\ActivityLog::ACTION_USER_DELETED])): ?>
                                                    <form action="<?php echo e(route('admin.vendor-actions.reverse', $log)); ?>" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The user account will be restored/reactivated.');">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                <?php elseif($log->actor_type === 'vendor' && $log->subject_type === \App\Models\Order::class && in_array($log->action, [\App\Models\ActivityLog::ACTION_ORDER_DELETED, \App\Models\ActivityLog::ACTION_ORDER_CANCELLED])): ?>
                                                    <form action="<?php echo e(route('admin.vendor-actions.reverse', $log)); ?>" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The order will be restored.');">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                <?php elseif($log->actor_type === 'vendor' && $log->subject_type === \App\Models\AdminProduct::class && $log->action === \App\Models\ActivityLog::ACTION_PRODUCT_DELETED): ?>
                                                    <form action="<?php echo e(route('admin.vendor-actions.reverse', $log)); ?>" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The product will be restored.');">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No activity logs found.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logs->hasPages()): ?>
                    <div class="mt-4">
                        <?php echo e($logs->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <form id="delete-log-form" method="POST" action="" style="display: none;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                </form>
            </div>
        </main>
   
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\activity.blade.php ENDPATH**/ ?>