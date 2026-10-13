<?php $__env->startPush('title'); ?>
    <title>Dashboard - Khyber Pro</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .metric-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            padding: 16px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
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
            color: #ffffff;
            font-size: 1.15rem;
        }
        .metric-content {
            flex: 1;
            min-width: 0;
        }
        .metric-number {
            font-size: 1.55rem;
            font-weight: 800;
            line-height: 1.1;
            color: #004b49;
            margin-bottom: 2px;
        }
        .metric-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0;
        }
        .card-clean {
            border: 1px solid #eef2f6;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
            padding: 20px 22px;
        }
        .quick-tool-link {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 11px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1e293b;
            font-weight: 600;
            font-size: 0.88rem;
            transition: all 0.2s ease;
        }
        .quick-tool-link:hover {
            background: #f8fafc;
            border-color: #0284c7;
            color: #0284c7;
            transform: translateX(2px);
        }
        .credential-clean-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 14px 18px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main style="background-color: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-3 px-md-4 py-4">

        <!-- Clean, Spacious Header with Properly Aligned Action Buttons -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Dashboard</h2>
                <p class="text-muted small mb-0">Overview & management of staff, orders, and store activity</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success rounded-pill px-3 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#quickAddEmployeeModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Add Employee
                </button>
                <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-people me-1"></i> Employees
                </a>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Credentials Alert (if employee created directly from dashboard) -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('new_credentials')): ?>
            <?php $creds = session('new_credentials'); ?>
            <div class="credential-clean-box shadow-sm d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-success rounded-pill px-2.5 py-1">
                            <i class="bi bi-key-fill me-1"></i> Credentials Created
                        </span>
                        <strong class="text-dark"><?php echo e($creds['name']); ?></strong>
                    </div>
                    <div class="small text-muted">
                        Email: <code class="text-dark fw-bold bg-white px-2 py-0.5 rounded border"><?php echo e($creds['email']); ?></code> | 
                        Password: <code class="text-success fw-bold bg-white px-2 py-0.5 rounded border"><?php echo e($creds['password']); ?></code>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3" onclick="copyDashboardCredentials('<?php echo e($creds['name']); ?>', '<?php echo e($creds['email']); ?>', '<?php echo e($creds['password']); ?>', '<?php echo e($creds['login_url']); ?>')">
                        <i class="bi bi-clipboard-check me-1"></i> <span id="dashCopyText">Copy Credentials</span>
                    </button>
                    <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-sm btn-outline-success rounded-pill px-3">
                        View Staff List →
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 5 Clean Metric Cards in a Single Row -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
            
            <!-- Revenue -->
            <div class="col">
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: #14532d;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number">$<?php echo e(number_format((float) ($stats['revenue'] ?? 0), 2)); ?></div>
                        <div class="metric-title">Revenue</div>
                    </div>
                </a>
            </div>

            <!-- Orders -->
            <div class="col">
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: #346548;">
                        <i class="bi bi-basket"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['orders'] ?? 0)); ?></div>
                        <div class="metric-title">Orders</div>
                    </div>
                </a>
            </div>

            <!-- Employees -->
            <div class="col">
                <a href="<?php echo e(route('admin.employees.index')); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: #199d4b;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['employees'] ?? 0)); ?></div>
                        <div class="metric-title">Employees</div>
                    </div>
                </a>
            </div>

            <!-- Customers -->
            <div class="col">
                <a href="<?php echo e(route('admin.users.index')); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: #0b6b7b;">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['customers'] ?? 0)); ?></div>
                        <div class="metric-title">Customers</div>
                    </div>
                </a>
            </div>

            <!-- Products -->
            <div class="col">
                <a href="<?php echo e(url('admin/view-product')); ?>" class="metric-card">
                    <div class="metric-icon-box" style="background-color: <?php echo e(($stats['outOfStock'] ?? 0) > 0 ? '#c91c22' : '#c27803'); ?>;">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['products'] ?? 0)); ?></div>
                        <div class="metric-title">Products</div>
                    </div>
                </a>
            </div>

        </div>

        <!-- 2 Column Clean Content Section -->
        <div class="row g-4">
            
            <!-- Left Main Column (8 cols) -->
            <div class="col-lg-8">
                
                <!-- Employees Quick Table -->
                <div class="card-clean mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-people text-success me-2"></i> Employees
                        </h5>
                        <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All (<?php echo e($stats['employees'] ?? 0); ?>)
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Employee</th>
                                    <th>Login Email</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentEmployees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 34px; height: 34px; font-size: 0.82rem;">
                                                    <?php echo e(mb_substr($emp->name, 0, 2)); ?>

                                                </div>
                                                <div class="fw-bold text-dark small"><?php echo e($emp->name); ?></div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-monospace small text-dark"><?php echo e($emp->email); ?></span>
                                        </td>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emp->status === 'active'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.72rem;">
                                                    Active
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.72rem;">
                                                    Suspended
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="small text-muted"><?php echo e($emp->created_at?->format('M d, Y') ?? '—'); ?></span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="<?php echo e(route('admin.employees.index', ['search' => $emp->email])); ?>" class="btn btn-sm btn-outline-primary rounded-pill py-1 px-3" style="font-size: 0.78rem;">
                                                Manage
                                            </a>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted small">
                                            No employees found. Click "Add Employee" above to generate staff credentials.
                                        </td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Orders Table -->
                <div class="card-clean">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-basket text-primary me-2"></i> Recent Orders
                        </h5>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            View All Orders
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary font-monospace small">
                                            <?php echo e($order['id']); ?>

                                        </td>
                                        <td class="fw-medium text-dark small">
                                            <?php echo e($order['customer']); ?>

                                        </td>
                                        <td class="small text-muted">
                                            <?php echo e($order['date']); ?>

                                        </td>
                                        <td class="fw-bold text-dark small">
                                            $<?php echo e($order['total']); ?>

                                        </td>
                                        <td>
                                            <?php
                                                $st = strtolower($order['status']);
                                                $bg = match($st) {
                                                    'completed' => 'success',
                                                    'pending' => 'warning',
                                                    'cancelled' => 'danger',
                                                    default => 'info'
                                                };
                                            ?>
                                            <span class="badge bg-<?php echo e($bg); ?>-subtle text-<?php echo e($bg); ?> border border-<?php echo e($bg); ?> border-opacity-25 rounded-pill px-2 py-0.5" style="font-size: 0.72rem;">
                                                <?php echo e($order['status']); ?>

                                            </span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="<?php echo e(route('admin.orders.details', $order['key'])); ?>" class="btn btn-sm btn-light border rounded-pill py-0 px-2" style="font-size: 0.78rem;">
                                                Details →
                                            </a>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted small">No recent orders recorded.</td>
                                    </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Right Column (4 cols) -->
            <div class="col-lg-4">

                <!-- Quick Tools -->
                <div class="card-clean mb-4">
                    <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                        <i class="bi bi-tools text-secondary me-2"></i> Quick Tools
                    </h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo e(route('admin.employees.index')); ?>" class="quick-tool-link">
                            <i class="bi bi-person-lines-fill text-success fs-5"></i>
                            <span class="flex-grow-1">Employees Hub</span>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>

                        <a href="<?php echo e(route('admin.excel.create')); ?>" class="quick-tool-link">
                            <i class="bi bi-file-earmark-excel text-primary fs-5"></i>
                            <span class="flex-grow-1">Create Excel Report</span>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>

                        <a href="<?php echo e(route('admin.paypal.blacklisted')); ?>" class="quick-tool-link">
                            <i class="bi bi-shield-x text-danger fs-5"></i>
                            <span class="flex-grow-1">Blacklisted PayPal</span>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>

                        <a href="<?php echo e(route('admin.reservations.index')); ?>" class="quick-tool-link">
                            <i class="bi bi-calendar-check text-info fs-5"></i>
                            <span class="flex-grow-1">Reservations</span>
                            <i class="bi bi-chevron-right text-muted small"></i>
                        </a>
                    </div>
                </div>

                <!-- Stock Alerts -->
                <div class="card-clean mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <h6 class="fw-bold text-dark mb-0">
                            <i class="bi bi-exclamation-triangle text-warning me-2"></i> Low Stock Alerts
                        </h6>
                        <span class="badge bg-warning bg-opacity-25 text-dark rounded-pill">
                            <?php echo e(count($inventoryAlert)); ?>

                        </span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($inventoryAlert) > 0): ?>
                        <div class="d-flex flex-column gap-2" style="max-height: 220px; overflow-y: auto;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $inventoryAlert->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <div class="p-2 border rounded-3 bg-light d-flex justify-content-between align-items-center">
                                    <div class="text-truncate me-2" style="max-width: 180px;">
                                        <div class="fw-bold text-dark small text-truncate"><?php echo e($item->name); ?></div>
                                        <div class="text-muted" style="font-size: 0.72rem;">SKU: <?php echo e($item->sku ?? 'N/A'); ?></div>
                                    </div>
                                    <span class="badge <?php echo e($item->quantity <= 0 ? 'bg-danger' : 'bg-warning text-dark'); ?> rounded-pill px-2 py-1">
                                        <?php echo e($item->quantity <= 0 ? 'Out' : $item->quantity . ' left'); ?>

                                    </span>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-3 text-muted small">
                            <i class="bi bi-check-circle text-success fs-4 d-block mb-1"></i>
                            All products are well stocked!
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Recent Activity -->
                <div class="card-clean">
                    <h6 class="fw-bold text-dark mb-3 pb-2 border-bottom">
                        <i class="bi bi-clock-history text-secondary me-2"></i> Recent Activity
                    </h6>
                    <div class="d-flex flex-column gap-2" style="max-height: 220px; overflow-y: auto;">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="p-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-semibold text-dark small" style="font-size: 0.8rem;">
                                        <?php echo e($log->actor->name ?? 'System'); ?>

                                    </span>
                                    <span class="text-muted" style="font-size: 0.7rem;">
                                        <?php echo e($log->created_at->diffForHumans()); ?>

                                    </span>
                                </div>
                                <div class="text-muted mt-1 text-truncate" style="font-size: 0.75rem;">
                                    <?php echo e($log->description); ?>

                                </div>
                            </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <div class="text-center py-3 text-muted small">No recent activity logs.</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>

<!-- Quick Add Employee Modal -->
<div class="modal fade" id="quickAddEmployeeModal" tabindex="-1" aria-labelledby="quickAddEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 650px;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Modal Header -->
            <div class="modal-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-size: 1.25rem;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="quickAddEmployeeModalLabel">Create Employee Account</h5>
                        <small class="text-muted">Set up credentials & portal access for staff</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Form -->
            <form action="<?php echo e(route('admin.employees.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="quick_emp_name" class="form-label fw-bold small text-dark mb-1">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control rounded-3 py-2" id="quick_emp_name" name="name" required placeholder="e.g. Ahmad Khan">
                        </div>

                        <div class="col-md-6">
                            <label for="quick_emp_email" class="form-label fw-bold small text-dark mb-1">
                                Email Address (Login ID) <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control rounded-3 py-2" id="quick_emp_email" name="email" required placeholder="e.g. ahmad@khyberpro.com">
                        </div>

                        <div class="col-md-6">
                            <label for="quick_emp_phone" class="form-label fw-bold small text-dark mb-1">
                                Phone / WhatsApp
                            </label>
                            <input type="text" class="form-control rounded-3 py-2" id="quick_emp_phone" name="phone" placeholder="e.g. +92 300 1234567">
                        </div>

                        <div class="col-md-6">
                            <label for="quick_emp_status" class="form-label fw-bold small text-dark mb-1">
                                Account Status
                            </label>
                            <select name="status" id="quick_emp_status" class="form-select rounded-3 py-2">
                                <option value="active" selected>Active (Immediate Login)</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="quick_emp_password" class="form-label fw-bold small mb-0 text-dark">
                                        Temporary Password <span class="text-danger">*</span>
                                    </label>
                                    <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-2.5 py-0.5 fw-semibold" onclick="generateQuickPass()" style="font-size: 0.78rem;">
                                        <i class="bi bi-magic me-1"></i> Auto-Generate
                                    </button>
                                </div>
                                <input type="text" class="form-control font-monospace bg-white rounded-3 py-2" id="quick_emp_password" name="password" required minlength="6" placeholder="Enter or auto-generate password">
                                <small class="text-muted d-block mt-2" style="font-size: 0.78rem;">
                                    <i class="bi bi-shield-check text-success me-1"></i> Once created, full credentials will be ready for one-click copy to WhatsApp / SMS.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top bg-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-1.5 fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-pill px-4 py-1.5 fw-semibold shadow-sm">
                        <i class="bi bi-check-lg me-1"></i> Create Employee Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generateQuickPass() {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
        let pass = '';
        for (let i = 0; i < 10; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('quick_emp_password').value = pass;
    }

    function copyDashboardCredentials(name, email, password, loginUrl) {
        const msg = `Assalam-o-Alaikum / Hello ${name},\n\nHere are your Khyber Pro Employee login credentials:\n🌐 Portal URL: ${loginUrl}\n📧 Email: ${email}\n🔑 Password: ${password}\n\nPlease log in and access your employee dashboard.`;
        navigator.clipboard.writeText(msg).then(() => {
            const btn = document.getElementById('dashCopyText');
            const orig = btn.innerText;
            btn.innerText = 'Copied! ✓';
            setTimeout(() => { btn.innerText = orig; }, 3000);
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\index.blade.php ENDPATH**/ ?>