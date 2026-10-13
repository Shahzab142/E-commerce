<?php $__env->startPush('title'); ?>
    <title>Delay Refunds Management - Admin Portal</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<style>
    .stat-card-clean {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }
    .stat-card-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.07);
    }
    .stat-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .refund-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .refund-table thead th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .refund-table tbody td {
        padding: 16px;
        vertical-align: middle;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .refund-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .filter-input {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        padding: 10px 14px;
        font-size: 0.9rem;
    }
    .filter-input:focus {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .status-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-action-sm {
        padding: 6px 12px;
        font-size: 0.825rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center">
                <i class="bi bi-dash-circle text-warning me-2"></i> Delay Refunds Management
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Delay Refunds</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('admin.paypal.blacklisted')); ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-semibold">
                <i class="bi bi-paypal me-1"></i> Check PayPal Blacklist
            </a>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-primary btn-sm rounded-pill px-3 fw-semibold">
                <i class="bi bi-basket me-1"></i> All Orders
            </a>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div class="fw-medium"><?php echo e(session('success')); ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Metric Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-clean d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total Delayed Orders</div>
                    <div class="fw-bold text-dark fs-4"><?php echo e($stats['total']); ?></div>
                    <div class="text-muted small">Orders flagged for delay</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-clean d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-pause-circle"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">On-Hold Refunds</div>
                    <div class="fw-bold text-dark fs-4"><?php echo e($stats['on_hold']); ?></div>
                    <div class="text-danger small fw-medium">Requires Admin action</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-clean d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-info bg-opacity-10 text-info">
                    <i class="bi bi-search"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Under Review</div>
                    <div class="fw-bold text-dark fs-4"><?php echo e($stats['pending_review']); ?></div>
                    <div class="text-info small fw-medium">Pending dispute checks</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card-clean d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Total Delayed Value</div>
                    <div class="fw-bold text-dark fs-4">$<?php echo e(number_format($stats['total_amount'], 2)); ?></div>
                    <div class="text-success small fw-medium"><?php echo e($stats['refunded']); ?> already refunded</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="refund-table-card">
        <!-- Filter Bar -->
        <div class="p-3 border-bottom bg-white">
            <form action="<?php echo e(route('admin.delay-refunds')); ?>" method="GET" class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control filter-input border-start-0" placeholder="Search by Order #, Customer Name, or Email...">
                    </div>
                </div>

                <div class="col-6 col-md-4">
                    <select name="status" class="form-select filter-input">
                        <option value="all" <?php echo e(request('status') == 'all' ? 'selected' : ''); ?>>All Refund / Delayed Statuses</option>
                        <option value="on_hold" <?php echo e(request('status') == 'on_hold' ? 'selected' : ''); ?>>On Hold</option>
                        <option value="refunded_pending_review" <?php echo e(request('status') == 'refunded_pending_review' ? 'selected' : ''); ?>>Pending Review</option>
                        <option value="review_submitted_refund" <?php echo e(request('status') == 'review_submitted_refund' ? 'selected' : ''); ?>>Review Submitted</option>
                        <option value="refunded" <?php echo e(request('status') == 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                        <option value="cancelled" <?php echo e(request('status') == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                    </select>
                </div>

                <div class="col-6 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary fw-semibold px-3 rounded-3 flex-grow-1">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['search', 'status'])): ?>
                        <a href="<?php echo e(route('admin.delay-refunds')); ?>" class="btn btn-outline-secondary rounded-3 px-3">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="table-responsive">
            <table class="table refund-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Order Details</th>
                        <th>Customer</th>
                        <th>Product Items</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $delayedOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-muted fw-semibold">
                                <?php echo e(($delayedOrders->currentPage() - 1) * $delayedOrders->perPage() + $loop->iteration); ?>

                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($order->order_number); ?></div>
                                <div class="text-muted small">
                                    <i class="bi bi-calendar3 me-1"></i><?php echo e($order->placed_at?->format('d M, Y h:i A') ?? $order->created_at->format('d M, Y')); ?>

                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->payment_method): ?>
                                    <span class="badge bg-light text-secondary border small mt-1">
                                        <i class="bi bi-credit-card me-1"></i><?php echo e(strtoupper($order->payment_method)); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?php echo e($order->user->name ?? $order->shipping_name ?? 'Guest Buyer'); ?></div>
                                <div class="text-muted small"><?php echo e($order->user->email ?? 'No email'); ?></div>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->items->isNotEmpty()): ?>
                                    <div class="fw-medium text-dark"><?php echo e(Str::limit($order->items->first()->product_name ?? 'Product item', 28)); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->items->count() > 1): ?>
                                        <div class="text-muted small">+<?php echo e($order->items->count() - 1); ?> more item(s)</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted small">No items recorded</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6">$<?php echo e(number_format((float)$order->total, 2)); ?></div>
                            </td>
                            <td>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($order->status == 'on_hold'): ?>
                                    <span class="status-badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-25">
                                        <i class="bi bi-pause-fill"></i> On Hold
                                    </span>
                                <?php elseif($order->status == 'refunded_pending_review'): ?>
                                    <span class="status-badge bg-info bg-opacity-15 text-info border border-info border-opacity-25">
                                        <i class="bi bi-clock-history"></i> Pending Review
                                    </span>
                                <?php elseif($order->status == 'review_submitted_refund'): ?>
                                    <span class="status-badge bg-primary bg-opacity-15 text-primary border border-primary border-opacity-25">
                                        <i class="bi bi-file-earmark-check"></i> Review Submitted
                                    </span>
                                <?php elseif($order->status == 'refunded'): ?>
                                    <span class="status-badge bg-success bg-opacity-15 text-success border border-success border-opacity-25">
                                        <i class="bi bi-check-circle-fill"></i> Refunded
                                    </span>
                                <?php elseif($order->status == 'cancelled'): ?>
                                    <span class="status-badge bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25">
                                        <i class="bi bi-x-circle-fill"></i> Cancelled
                                    </span>
                                <?php else: ?>
                                    <span class="status-badge bg-secondary bg-opacity-15 text-secondary border">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $order->status))); ?>

                                    </span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <button type="button" class="btn btn-action-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateRefundModal-<?php echo e($order->id); ?>">
                                        <i class="bi bi-pencil-square"></i> Status
                                    </button>
                                    <a href="<?php echo e(route('admin.orders.details', $order->id)); ?>" class="btn btn-action-sm btn-light text-muted border">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>

                                <!-- Status Update Modal -->
                                <div class="modal fade text-start" id="updateRefundModal-<?php echo e($order->id); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            <div class="modal-header border-bottom px-4 py-3">
                                                <h5 class="modal-title fw-bold text-dark">
                                                    <i class="bi bi-sliders text-primary me-2"></i> Update Order #<?php echo e($order->order_number); ?>

                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="<?php echo e(route('admin.delay-refunds.update-status', $order->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <div class="modal-body p-4">
                                                    <div class="p-3 bg-light rounded-3 mb-3 d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="text-muted small">Current Status</div>
                                                            <div class="fw-bold text-dark text-capitalize"><?php echo e(str_replace('_', ' ', $order->status)); ?></div>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="text-muted small">Order Total</div>
                                                            <div class="fw-bold text-success fs-6">$<?php echo e(number_format((float)$order->total, 2)); ?></div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-dark fw-semibold small">New Status</label>
                                                        <select name="status" class="form-select filter-input" required>
                                                            <option value="refunded" <?php echo e($order->status == 'refunded' ? 'selected' : ''); ?>>Approve & Mark as Refunded</option>
                                                            <option value="on_hold" <?php echo e($order->status == 'on_hold' ? 'selected' : ''); ?>>Put On Hold (Delayed)</option>
                                                            <option value="refunded_pending_review" <?php echo e($order->status == 'refunded_pending_review' ? 'selected' : ''); ?>>Pending Dispute Review</option>
                                                            <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Release Hold (Set to Processing)</option>
                                                            <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancel Order</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label text-dark fw-semibold small">Admin Notes / Reason (Optional)</label>
                                                        <textarea name="notes" class="form-control filter-input" rows="3" placeholder="Enter resolution notes, PayPal transaction ID or reason for delay..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top px-4 py-3">
                                                    <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-semibold">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-check2-circle text-success fs-1 d-block mb-2"></i>
                                <h6 class="fw-bold text-dark mb-1">No Delayed or Pending Refunds Found</h6>
                                <p class="text-muted small mb-0">All refund requests are up to date and no held orders require attention.</p>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($delayedOrders->hasPages()): ?>
            <div class="p-3 border-top d-flex justify-content-end bg-white">
                <?php echo e($delayedOrders->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\delay-refunds.blade.php ENDPATH**/ ?>