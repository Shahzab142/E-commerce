<?php $__env->startPush('title'); ?>
    <title>Employee Dashboard - Khyber Pro</title>
    <style>
        .metric-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            padding: 18px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 120px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
            color: inherit;
        }
        .metric-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .metric-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .metric-number {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.1;
            color: #004b49;
            margin-bottom: 3px;
            letter-spacing: -0.5px;
        }
        .metric-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #4b5563;
            line-height: 1.25;
            margin-bottom: 2px;
            word-wrap: break-word;
        }
        .metric-sub {
            font-size: 0.72rem;
            color: #9ca3af;
            line-height: 1.2;
            transition: color 0.2s;
        }
        .metric-card:hover .metric-sub {
            color: #004b49;
        }
        .dashboard-header {
            text-align: center;
            padding: 6px 0 22px;
        }
        .dashboard-header h6 {
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .dashboard-header h2 {
            font-weight: 800;
            color: #1e3a8a;
            font-size: 1.85rem;
            letter-spacing: -0.5px;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #eef2f6;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="dashboard-header">
            <h6>DASHBOARD</h6>
            <h2>Orders Overview</h2>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-shield-slash-fill me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 10 Stat Cards Matching Client's Reference Design (5 per row on desktop) -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
            <?php
                $cards = [
                    [
                        'title' => 'Completed',
                        'val' => number_format($stats['completed']),
                        'bg' => '#14532d', // Forest Dark Green (Institutes style)
                        'icon' => 'bi-building',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'completed'),
                    ],
                    [
                        'title' => 'Total Orders',
                        'val' => number_format($stats['ordered']),
                        'bg' => '#346548', // Sage / Olive Green (Total Systems style)
                        'icon' => 'bi-display',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'ordered'),
                    ],
                    [
                        'title' => 'Reviewed',
                        'val' => number_format($stats['reviewed']),
                        'bg' => '#0b6b7b', // Ocean Teal (Connected style)
                        'icon' => 'bi-wifi',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'reviewed'),
                    ],
                    [
                        'title' => 'Commissioned',
                        'val' => number_format($stats['commissioned']),
                        'bg' => '#199d4b', // Vibrant Emerald (Active style)
                        'icon' => 'bi-activity',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'commissioned'),
                    ],
                    [
                        'title' => 'On Hold',
                        'val' => number_format($stats['on_hold']),
                        'bg' => '#c27803', // Ochre / Warm Amber (Idle style)
                        'icon' => 'bi-clock',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'on-hold'),
                    ],
                    [
                        'title' => 'Refunded',
                        'val' => number_format($stats['refunded']),
                        'bg' => '#c91c22', // Crimson Red (Offline style)
                        'icon' => 'bi-slash-circle',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'refunded'),
                    ],
                    [
                        'title' => 'Cancelled',
                        'val' => number_format($stats['cancelled']),
                        'bg' => '#991b1b', // Deep Red
                        'icon' => 'bi-x-circle',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'cancelled'),
                    ],
                    [
                        'title' => 'Refund Pending',
                        'val' => number_format($stats['refunded_pending_review']),
                        'bg' => '#3b49df', // Indigo
                        'icon' => 'bi-arrow-repeat',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'refunded-pending-review'),
                    ],
                    [
                        'title' => 'Review Submitted',
                        'val' => number_format($stats['review_submitted_refund']),
                        'bg' => '#0284c7', // Sky Blue
                        'icon' => 'bi-hand-thumbs-up',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'review-submitted-refund'),
                    ],
                    [
                        'title' => 'Review Deleted',
                        'val' => number_format($stats['review_deleted']),
                        'bg' => '#64748b', // Slate Gray
                        'icon' => 'bi-trash3',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'review-deleted'),
                    ],
                ];
            ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="col">
                <a href="<?php echo e($card['route']); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: <?php echo e($card['bg']); ?>;">
                        <i class="bi <?php echo e($card['icon']); ?> text-white fs-5"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e($card['val']); ?></div>
                        <div class="metric-title"><?php echo e($card['title']); ?></div>
                        <div class="metric-sub"><?php echo e($card['sub']); ?></div>
                    </div>
                </a>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <!-- 2 Overview Sections as shown in video: Completed Orders & Order By Status -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Completed Orders</h5>
                        <a href="<?php echo e(route('employee.orders', 'completed')); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">View All</a>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($completedOrders->isEmpty()): ?>
                        <div class="p-4 text-center text-muted bg-light rounded-3">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            No completed orders found.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $completedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr>
                                        <td class="fw-semibold text-primary"><?php echo e($order->order_number); ?></td>
                                        <td><?php echo e($order->user->name ?? 'N/A'); ?></td>
                                        <td>$<?php echo e(number_format($order->total, 2)); ?></td>
                                        <td class="text-muted"><?php echo e($order->created_at->format('d M, Y')); ?></td>
                                    </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Order By Status</h5>
                    </div>
                    <div class="row g-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $ordersByStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stName => $stCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                <span class="fw-medium text-secondary"><?php echo e($stName); ?></span>
                                <span class="badge bg-success rounded-pill px-3 py-2 fs-6"><?php echo e($stCount); ?></span>
                            </div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/employee/index.blade.php ENDPATH**/ ?>