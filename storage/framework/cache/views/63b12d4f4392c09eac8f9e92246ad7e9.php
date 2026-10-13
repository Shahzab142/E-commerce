<?php $__env->startPush('title'); ?>
    <title>Orders - Employee Portal</title>
    <style>
        .search-box-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
        }
        .search-input-group {
            position: relative;
            margin-bottom: 12px;
        }
        .search-input-group .form-control {
            border-radius: 8px 0 0 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 16px;
            font-size: 0.95rem;
        }
        .search-input-group .btn-search {
            border-radius: 0 8px 8px 0;
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            padding: 0 20px;
        }
        .search-input-group .btn-search:hover {
            background-color: #0369a1;
        }
        .orders-table-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-navy" style="color: #1e3a8a;">Orders</h2>
            <p class="text-muted">Viewing status: <span class="badge bg-success text-uppercase"><?php echo e(str_replace('-', ' ', $currentStatus)); ?></span></p>
        </div>

        <!-- 3 Search Bars matching the video -->
        <div class="search-box-card">
            <form action="<?php echo e(route('employee.orders', $currentStatus)); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="customer_email" class="form-control" placeholder="Search by customer email..." value="<?php echo e(request('customer_email')); ?>">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="product_id" class="form-control" placeholder="Search by product ID..." value="<?php echo e(request('product_id')); ?>">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="order_number" class="form-control" placeholder="Search by order #..." value="<?php echo e(request('order_number')); ?>">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Orders Table -->
        <div class="orders-table-card">
            <h5 class="fw-bold mb-4 text-dark">Active Orders</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Seller</th>
                            <th>User</th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Customer Email</th>
                            <th>Market</th>
                            <th>Type</th>
                            <th>Update Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <a href="https://wa.me/923001234567" target="_blank" class="btn btn-sm btn-outline-success rounded-circle p-1" title="WhatsApp Seller">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </td>
                            <td><?php echo e($order->user->name ?? 'Customer'); ?></td>
                            <td class="fw-semibold text-primary"><?php echo e($order->order_number); ?></td>
                            <td><?php echo e($order->items->first()?->product_name ?? 'Product'); ?></td>
                            <td><?php echo e($order->user->email ?? 'N/A'); ?></td>
                            <td><span class="badge bg-light text-dark border">US</span></td>
                            <td>Text Review</td>
                            <td><?php echo e($order->updated_at->format('d M, Y')); ?></td>
                            <td>
                                <?php
                                    $badgeClass = match($order->status) {
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'refunded' => 'bg-warning text-dark',
                                        'on_hold' => 'bg-secondary',
                                        default => 'bg-info text-dark',
                                    };
                                ?>
                                <span class="badge <?php echo e($badgeClass); ?> status-badge"><?php echo e(str_replace('_', ' ', $order->status)); ?></span>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-2 d-block mb-2 text-secondary"></i>
                                No orders found under this filter.
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($orders->hasPages()): ?>
                <div class="mt-4 d-flex justify-content-center">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\orders.blade.php ENDPATH**/ ?>