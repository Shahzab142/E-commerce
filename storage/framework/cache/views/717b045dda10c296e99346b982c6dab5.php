<?php $__env->startPush('title'); ?>
    <title>Delay Refund - Employee Portal</title>
    <style>
        .delay-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Delay Refund</h2>
            <p class="text-muted">Total Pending Refund Orders = ( <strong class="text-primary"><?php echo e($delayedOrders->count()); ?></strong> )</p>
        </div>

        <div class="delay-card">
            <h5 class="fw-bold mb-4 text-dark">Sellers / Pending Refund Orders</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Product ID</th>
                            <th>Order Number</th>
                            <th>Order Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $delayedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                            <td class="fw-semibold text-dark"><?php echo e($order->user->name ?? 'Customer'); ?></td>
                            <td class="fw-bold text-primary">#<?php echo e($order->items->first()?->product_id ?? 'N/A'); ?></td>
                            <td class="fw-semibold text-secondary"><?php echo e($order->order_number); ?></td>
                            <td><?php echo e($order->created_at->format('d M, Y')); ?></td>
                            <td>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <?php echo e(str_replace('_', ' ', $order->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-2 d-block mb-2 text-secondary"></i>
                                No delayed refund orders found.
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/employee/delay-refunds.blade.php ENDPATH**/ ?>