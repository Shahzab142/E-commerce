<?php $__env->startSection('title', 'Order History'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-clock-history me-2 text-primary"></i>
                Order History
            </h1>
            <p class="text-muted mb-0">
                View and track all your previous orders.
            </p>
        </div>

        <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-cart3 me-1"></i>
            Continue Shopping
        </a>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">My Orders</h5>
                    <p class="text-muted small mb-0">
                        Your complete order history
                    </p>
                </div>

                <span class="badge bg-primary rounded-pill px-3 py-2">
                    <?php echo e($orders->count()); ?> Orders
                </span>
            </div>
        </div>

        <div class="card-body p-0">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->count() > 0): ?>

                
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Order</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Items</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Status</th>
                                <th class="text-end px-4 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                                <?php
                                    $status = strtolower($order->status ?? 'pending');

                                    $statusClass = match($status) {
                                        'delivered' => 'bg-success',
                                        'processing' => 'bg-warning text-dark',
                                        'shipped' => 'bg-info text-dark',
                                        'cancelled', 'canceled' => 'bg-danger',
                                        'pending' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };
                                ?>

                                <tr>

                                    
                                    <td class="px-4">
                                        <span class="fw-semibold text-dark">
                                            #<?php echo e($order->id); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <div class="fw-medium">
                                            <?php echo e($order->created_at?->format('d M Y')); ?>

                                        </div>
                                        <small class="text-muted">
                                            <?php echo e($order->created_at?->format('h:i A')); ?>

                                        </small>
                                    </td>

                                    
                                    <td>
                                        <?php
                                            $itemsCount = $order->orderItems?->count()
                                                ?? $order->items?->count()
                                                ?? 0;
                                        ?>

                                        <span class="text-muted">
                                            <?php echo e($itemsCount); ?>

                                            <?php echo e($itemsCount == 1 ? 'item' : 'items'); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <span class="fw-bold text-dark">
                                           $ <?php echo e(number_format($order->total ?? 0, 2)); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <span class="badge <?php echo e($statusClass); ?> rounded-pill px-3 py-2 text-capitalize">
                                            <?php echo e($status); ?>

                                        </span>
                                    </td>

                                    
                                    <td class="text-end px-4">
                                        <a href="<?php echo e(url('user/details/' . $order->id)); ?>"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>
                                    </td>

                                </tr>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </tbody>

                    </table>
                </div>

            <?php else: ?>

                
                <div class="text-center py-5 px-4">

                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
                         style="width: 90px; height: 90px;">

                        <i class="bi bi-bag-x text-primary"
                           style="font-size: 2.5rem;"></i>

                    </div>

                    <h4 class="fw-bold text-dark mb-2">
                        No Orders Yet
                    </h4>

                    <p class="text-muted mb-4 mx-auto"
                       style="max-width: 450px;">
                        You haven't placed any orders yet. Explore our products
                        and place your first order.
                    </p>

                    <a href="<?php echo e(url('/')); ?>"
                       class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-shop me-2"></i>
                        Start Shopping
                    </a>

                </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\user\order-history.blade.php ENDPATH**/ ?>