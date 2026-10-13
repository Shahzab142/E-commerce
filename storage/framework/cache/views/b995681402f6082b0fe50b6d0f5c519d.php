<?php $__env->startPush('title'); ?>
    <title>Employee Management - Khyber Pro</title>
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
            height: 100%;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
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
        }
        .credential-clean-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px 20px;
        }
        .credential-code {
            font-family: 'Courier New', Courier, monospace;
            background: #ffffff;
            border: 1px dashed #86efac;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: 700;
            color: #166534;
            display: inline-block;
        }
        .table th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 13px 18px;
        }
        .table td {
            padding: 14px 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }
        .table tbody tr:hover {
            background-color: #f8fafc;
        }
        /* Modal Polish Styles */
        .modal-clean {
            border-radius: 18px;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.18);
            overflow: hidden;
        }
        .form-label-pro {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }
        .form-control-pro, .form-select-pro {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 0.88rem;
            color: #0f172a;
            transition: all 0.15s ease;
        }
        .form-control-pro:focus, .form-select-pro:focus {
            background-color: #ffffff;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
            outline: none;
        }
        .btn-primary-action {
            background-color: #16a34a;
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 9px 22px;
            border: none;
            box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25);
            transition: all 0.15s ease;
        }
        .btn-primary-action:hover {
            background-color: #15803d;
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.35);
        }
        .btn-cancel-ghost {
            color: #64748b;
            font-weight: 600;
            border-radius: 10px;
            padding: 9px 18px;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.15s ease;
        }
        .btn-cancel-ghost:hover {
            background: #f1f5f9;
            color: #1e293b;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main style="background-color: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-3 px-md-4 py-4 pb-5">

        <!-- Clean, Modern Header with Properly Aligned Action Buttons -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Employee Management</h2>
                <p class="text-muted small mb-0">Manage active staff, credentials, and portal access</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-success rounded-pill px-3 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                    <i class="bi bi-person-plus-fill me-1"></i> Add New Employee
                </button>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Please check the errors:</strong>
                <ul class="mb-0 mt-1 small">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <li><?php echo e($err); ?></li>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Prominent New Credentials Ready-To-Share Card -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('new_credentials')): ?>
            <?php $creds = session('new_credentials'); ?>
            <div class="credential-clean-box shadow-sm mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-success px-3 py-2 fs-6 rounded-pill">
                            <i class="bi bi-key-fill me-1"></i> <?php echo e(($creds['type'] ?? 'created') === 'reset' ? 'Password Reset Complete' : 'New Employee Account Created'); ?>

                        </span>
                        <span class="text-muted small">Ready to share with employee</span>
                    </div>
                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm fw-semibold" onclick="copyFullCredentials()">
                        <i class="bi bi-clipboard-check me-1"></i> <span id="copyBtnText">Copy for WhatsApp / SMS</span>
                    </button>
                </div>

                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="small text-muted mb-1">Employee Name</div>
                        <div class="fw-bold fs-6 text-dark"><?php echo e($creds['name']); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="small text-muted mb-1">Login Email</div>
                        <div class="credential-code"><?php echo e($creds['email']); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="small text-muted mb-1">Password</div>
                        <div class="credential-code"><?php echo e($creds['password']); ?></div>
                    </div>
                    <div class="col-md-3">
                        <div class="small text-muted mb-1">Portal Login URL</div>
                        <div class="text-truncate">
                            <a href="<?php echo e($creds['login_url']); ?>" target="_blank" class="fw-bold text-success text-decoration-none">
                                <?php echo e($creds['login_url']); ?> <i class="bi bi-box-arrow-up-right small"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-3 pt-2 border-top border-success border-opacity-25 d-flex align-items-center justify-content-between">
                    <span class="small text-success">
                        <i class="bi bi-shield-check me-1"></i> The employee can now log in at the portal with this email and password.
                    </span>
                    <button type="button" class="btn btn-link btn-sm text-secondary p-0 text-decoration-none" onclick="this.closest('.credential-clean-box').remove()">
                        Dismiss Box
                    </button>
                </div>
            </div>

            <textarea id="hiddenCredentialsText" style="display:none;">Assalam-o-Alaikum / Hello <?php echo e($creds['name']); ?>,

Here are your Khyber Pro Employee login credentials:
🌐 Portal URL: <?php echo e($creds['login_url']); ?>

📧 Email: <?php echo e($creds['email']); ?>

🔑 Password: <?php echo e($creds['password']); ?>


Please log in and access your employee dashboard.</textarea>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 4 Quick Stats Cards (Matching Modern Metric Card Style) -->
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #14532d;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['total'])); ?></div>
                        <div class="metric-title">Total Employees</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #16a34a;">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['active'])); ?></div>
                        <div class="metric-title">Active</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #d97706;">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['pending'])); ?></div>
                        <div class="metric-title">Pending</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #dc2626;">
                        <i class="bi bi-person-x-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($stats['suspended'])); ?></div>
                        <div class="metric-title">Suspended</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Clean Filter & Search Bar -->
        <div class="card card-clean p-3 mb-4">
            <form method="GET" action="<?php echo e(route('admin.employees.index')); ?>" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Search by name, email, or phone..." value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="all" <?php if(request('status') === 'all' || !request('status')): echo 'selected'; endif; ?>>All Statuses</option>
                        <option value="active" <?php if(request('status') === 'active'): echo 'selected'; endif; ?>>Active</option>
                        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
                        <option value="suspended" <?php if(in_array(request('status'), ['suspended', 'suspend'])): echo 'selected'; endif; ?>>Suspended</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill px-3 fw-semibold">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('search') || (request('status') && request('status') !== 'all')): ?>
                        <a href="<?php echo e(route('admin.employees.index')); ?>" class="btn btn-outline-secondary rounded-pill px-3 fw-semibold">
                            Clear
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Clean Employees Table -->
        <div class="card card-clean">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Employees List</h5>
                <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-semibold"><?php echo e($employees->total()); ?> accounts</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Employee</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th class="text-end pe-4" style="min-width: 260px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emp->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $emp->image)); ?>" alt="<?php echo e($emp->name); ?>" class="rounded-circle me-3" style="width: 38px; height: 38px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 38px; height: 38px; font-size: 0.85rem;">
                                                    <?php echo e(mb_substr($emp->name, 0, 2)); ?>

                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div>
                                                <div class="fw-bold text-dark"><?php echo e($emp->name); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium text-dark"><?php echo e($emp->email); ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?php echo e($emp->phone ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <span class="small text-muted"><?php echo e($emp->created_at?->format('M d, Y') ?? '—'); ?></span>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($emp->status === 'active'): ?>
                                            <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i> Active
                                            </span>
                                        <?php elseif($emp->status === 'pending'): ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                <i class="bi bi-clock-fill me-1"></i> Pending
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-pill fw-semibold">
                                                <i class="bi bi-x-circle-fill me-1"></i> Suspended
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4 text-nowrap" style="min-width: 260px;">
                                        <div class="d-inline-flex align-items-center gap-2">
                                            <!-- Status toggle form -->
                                            <form action="<?php echo e(route('admin.employees.status', $emp)); ?>" method="POST" class="d-inline mb-0">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PATCH'); ?>
                                                <select name="status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()" style="font-size: 0.78rem; width: 100px; padding: 4px 10px;">
                                                    <option value="active" <?php if($emp->status === 'active'): echo 'selected'; endif; ?>>Active</option>
                                                    <option value="suspended" <?php if(in_array($emp->status, ['suspended', 'suspend'])): echo 'selected'; endif; ?>>Suspend</option>
                                                </select>
                                            </form>

                                            <!-- Reset password modal trigger -->
                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 text-nowrap" style="font-size: 0.78rem;" title="Reset Password" data-bs-toggle="modal" data-bs-target="#resetPasswordModal<?php echo e($emp->id); ?>">
                                                <i class="bi bi-key-fill me-1"></i> Reset Pass
                                            </button>

                                            <!-- Delete Form -->
                                            <form action="<?php echo e(route('admin.employees.delete', $emp)); ?>" method="POST" class="d-inline mb-0" onsubmit="return confirm('Are you sure you want to delete employee <?php echo e($emp->name); ?>?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1" style="font-size: 0.78rem;" title="Delete Employee">
                                                    <i class="bi bi-trash3"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- Reset Password Modal for this Employee -->
                                        <div class="modal fade" id="resetPasswordModal<?php echo e($emp->id); ?>" tabindex="-1" aria-hidden="true" style="text-align: left;">
                                            <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
                                                <div class="modal-content modal-clean">
                                                    <div class="modal-header bg-white border-bottom border-light px-4 pt-4 pb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-size: 1.15rem;">
                                                                <i class="bi bi-key-fill"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="modal-title fs-6 fw-bold text-dark mb-0">Reset Password</h5>
                                                                <p class="text-muted small mb-0"><?php echo e($emp->name); ?></p>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="<?php echo e(route('admin.employees.reset-password', $emp)); ?>" method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <div class="modal-body px-4 py-4">
                                                            <div class="mb-3">
                                                                <label class="form-label-pro">Employee Email</label>
                                                                <input type="text" class="form-control form-control-pro bg-light" value="<?php echo e($emp->email); ?>" readonly>
                                                            </div>
                                                            <div class="mb-2">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <label class="form-label-pro mb-0">New Password <span class="text-danger">*</span></label>
                                                                    <button type="button" class="btn btn-sm btn-link text-primary p-0 text-decoration-none fw-semibold" onclick="generatePasswordForModal('reset_pass_<?php echo e($emp->id); ?>')" style="font-size: 0.8rem;">
                                                                        <i class="bi bi-magic me-1"></i> Auto-Generate
                                                                    </button>
                                                                </div>
                                                                <div class="input-group">
                                                                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 10px 0 0 10px; border-color: #e2e8f0;">
                                                                        <i class="bi bi-key"></i>
                                                                    </span>
                                                                    <input type="text" class="form-control form-control-pro font-monospace border-start-0" id="reset_pass_<?php echo e($emp->id); ?>" name="password" required minlength="6" placeholder="Enter or auto-generate password" style="border-radius: 0 10px 10px 0;">
                                                                </div>
                                                                <small class="text-muted d-block mt-1.5" style="font-size: 0.77rem;">
                                                                    <i class="bi bi-info-circle text-primary me-1"></i> New credentials will be presented for quick copying.
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer bg-light border-top border-light px-4 py-3 d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-cancel-ghost" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold shadow-sm" style="background-color: #2563eb; border-color: #2563eb;">
                                                                Update Password
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-people display-4 d-block mb-2 text-secondary opacity-50"></i>
                                        No employees found matching your criteria.
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($employees->hasPages()): ?>
                    <div class="p-3 border-top">
                        <?php echo e($employees->links()); ?>

                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

    </div>
</main>

<!-- Add New Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 620px;">
        <div class="modal-content modal-clean">
            <!-- Modal Header -->
            <div class="modal-header bg-white border-bottom border-light px-4 pt-4 pb-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0 fs-6" id="addEmployeeModalLabel">Create Employee Account</h5>
                        <p class="text-muted small mb-0">Set up credentials & portal access for staff</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Form -->
            <form action="<?php echo e(route('admin.employees.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body px-4 py-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="emp_name" class="form-label-pro">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-pro" id="emp_name" name="name" required placeholder="e.g. Ahmad Khan" value="<?php echo e(old('name')); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="emp_email" class="form-label-pro">
                                Email Address (Login ID) <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control form-control-pro" id="emp_email" name="email" required placeholder="e.g. ahmad@khyberpro.com" value="<?php echo e(old('email')); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="emp_phone" class="form-label-pro">
                                Phone / WhatsApp
                            </label>
                            <input type="text" class="form-control form-control-pro" id="emp_phone" name="phone" placeholder="e.g. +92 300 1234567" value="<?php echo e(old('phone')); ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="emp_status" class="form-label-pro">
                                Account Status
                            </label>
                            <select name="status" id="emp_status" class="form-select form-select-pro">
                                <option value="active" selected>Active (Immediate Login)</option>
                                <option value="pending">Pending</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="emp_password" class="form-label-pro mb-0">
                                    Temporary Password <span class="text-danger">*</span>
                                </label>
                                <button type="button" class="btn btn-sm btn-link text-success p-0 text-decoration-none fw-semibold" onclick="generatePasswordForModal('emp_password')" style="font-size: 0.8rem;">
                                    <i class="bi bi-magic me-1"></i> Auto-Generate
                                </button>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 10px 0 0 10px; border-color: #e2e8f0;">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="text" class="form-control form-control-pro font-monospace border-start-0" id="emp_password" name="password" required minlength="6" placeholder="At least 6 characters" value="<?php echo e(old('password')); ?>" style="border-radius: 0 10px 10px 0;">
                            </div>
                            <small class="text-muted d-block mt-1.5" style="font-size: 0.77rem;">
                                <i class="bi bi-shield-check text-success me-1"></i> Credentials will be presented for quick 1-click copy upon saving.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-top border-light px-4 py-3 d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-cancel-ghost" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-action">
                        <i class="bi bi-check-lg me-1"></i> Create Employee Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function generatePasswordForModal(targetInputId) {
        const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789!@#$%';
        let pass = '';
        for (let i = 0; i < 10; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById(targetInputId).value = pass;
    }

    function copyFullCredentials() {
        const textToCopy = document.getElementById('hiddenCredentialsText').value;
        navigator.clipboard.writeText(textToCopy).then(() => {
            const btn = document.getElementById('copyBtnText');
            const originalText = btn.innerText;
            btn.innerText = 'Copied to Clipboard! ✓';
            setTimeout(() => {
                btn.innerText = originalText;
            }, 3000);
        }).catch(err => {
            alert('Failed to copy. Please manually copy the credentials.');
        });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>