<?php $__env->startPush('title'); ?>
    <title>Admins & Management - Khyber Pro</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
<style>
    .metric-card-clean {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #eef2f6;
        padding: 16px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
        height: 100%;
    }
    .metric-card-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border-color: #cbd5e1;
    }
    .metric-icon-clean {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 1.15rem;
    }
    .metric-number-clean {
        font-size: 1.45rem;
        font-weight: 800;
        line-height: 1.1;
        color: #0f172a;
        margin-bottom: 2px;
    }
    .metric-title-clean {
        font-size: 0.8rem;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 0;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .card-clean {
        border: 1px solid #eef2f6;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }
    /* Segmented Tab Control */
    .segmented-tabs-wrapper {
        background: #f1f5f9;
        padding: 4px;
        border-radius: 10px;
        display: inline-flex;
        gap: 4px;
    }
    .segmented-tabs-wrapper .nav-link {
        color: #64748b;
        font-size: 0.83rem;
        font-weight: 600;
        border-radius: 8px;
        padding: 6px 14px;
        border: none;
        background: transparent;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .segmented-tabs-wrapper .nav-link.active {
        background: #ffffff;
        color: #0f172a;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .segmented-tabs-wrapper .nav-link:hover:not(.active) {
        color: #0f172a;
    }
    .pill-count {
        background: rgba(100, 116, 139, 0.12);
        color: #475569;
        font-size: 0.72rem;
        padding: 2px 7px;
        border-radius: 10px;
        font-weight: 700;
    }
    .segmented-tabs-wrapper .nav-link.active .pill-count {
        background: #e2e8f0;
        color: #0f172a;
    }

    /* Table Styles */
    .table-directory {
        margin-bottom: 0;
    }
    .table-directory thead th {
        font-size: 0.73rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 700;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 12px 18px;
        white-space: nowrap;
    }
    .table-directory tbody td {
        padding: 13px 18px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
    }
    .table-directory tbody tr:hover {
        background-color: #fafbfc;
    }
    .avatar-soft {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.82rem;
        flex-shrink: 0;
    }
    .badge-soft-green {
        background: #ecfdf5;
        color: #059669;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .badge-soft-green .dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background-color: #10b981;
    }
    .dept-tag {
        background-color: #f8fafc;
        color: #475569;
        border: 1px solid #e2e8f0;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 6px;
        display: inline-block;
    }
    .btn-wa-compact {
        background-color: #22c55e;
        color: #ffffff !important;
        font-size: 0.78rem;
        font-weight: 600;
        padding: 4px 11px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-wa-compact:hover {
        background-color: #16a34a;
        transform: translateY(-1px);
        color: #ffffff;
    }
    .search-input-clean {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.84rem;
        padding: 7px 12px 7px 32px;
        transition: all 0.15s ease;
        width: 230px;
    }
    .search-input-clean:focus {
        background: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        outline: none;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main style="background-color: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-3 px-md-4 py-4 pb-5">

        <!-- Clean, Lightweight Header -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2 border-bottom">
            <div>
                <h3 class="fw-bold mb-1" style="color: #0f172a; font-size: 1.45rem;">Admins & Management</h3>
                <p class="text-muted small mb-0">System administrators and departmental dispute resolution team</p>
            </div>
            <div>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-secondary rounded-pill px-3 py-1-5 fw-semibold btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        <!-- Sleek, Uniform KPI Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-xl-3">
                <div class="metric-card-clean">
                    <div class="metric-icon-clean" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number-clean"><?php echo e($stats['total_admins'] + $stats['total_managers']); ?></div>
                        <div class="metric-title-clean">Total Team</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="metric-card-clean">
                    <div class="metric-icon-clean" style="background-color: #f0fdf4; color: #16a34a;">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number-clean"><?php echo e($stats['total_admins']); ?></div>
                        <div class="metric-title-clean">Super Admins</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="metric-card-clean">
                    <div class="metric-icon-clean" style="background-color: #eff6ff; color: #2563eb;">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number-clean"><?php echo e($stats['total_managers']); ?></div>
                        <div class="metric-title-clean">Dept Managers</div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="metric-card-clean">
                    <div class="metric-icon-clean" style="background-color: #fef3c7; color: #d97706;">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                    <div>
                        <div class="metric-number-clean"><?php echo e($stats['active_departments']); ?></div>
                        <div class="metric-title-clean">Departments</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Single Clean Directory Card -->
        <div class="card-clean shadow-sm">
            <!-- Filter Bar: Segmented Tabs & Clean Search -->
            <div class="p-3 border-bottom bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="segmented-tabs-wrapper" id="adminsTab" role="tablist">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#tab-all" type="button" role="tab">
                        All Directory <span class="pill-count"><?php echo e($systemAdmins->count() + count($managementTeam)); ?></span>
                    </button>
                    <button class="nav-link" id="super-tab" data-bs-toggle="pill" data-bs-target="#tab-super" type="button" role="tab">
                        Super Admins <span class="pill-count"><?php echo e($systemAdmins->count()); ?></span>
                    </button>
                    <button class="nav-link" id="managers-tab" data-bs-toggle="pill" data-bs-target="#tab-managers" type="button" role="tab">
                        Managers <span class="pill-count"><?php echo e(count($managementTeam)); ?></span>
                    </button>
                </div>

                <div class="position-relative">
                    <i class="bi bi-search text-muted position-absolute" style="left: 11px; top: 50%; transform: translateY(-50%); font-size: 0.8rem;"></i>
                    <input type="text" id="quickSearchInput" class="search-input-clean" placeholder="Search by name, role...">
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="adminsTabContent">
                <!-- TAB 1: ALL DIRECTORY -->
                <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-directory align-middle" id="tableAll">
                            <thead>
                                <tr>
                                    <th style="width: 45px;">#</th>
                                    <th>Team Member</th>
                                    <th>Role & Department</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th class="text-center" style="width: 100px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 1; ?>

                                <!-- System Administrators -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $systemAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="team-row">
                                    <td class="text-muted fw-semibold"><?php echo e($counter++); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-soft" style="background-color: #e0f2fe; color: #0284c7;">
                                                <?php echo e(strtoupper(substr($adminUser->name, 0, 2))); ?>

                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark search-target">
                                                    <?php echo e($adminUser->name); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminUser->id === auth()->id()): ?>
                                                        <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.65rem; font-weight: 600;">You</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <div class="text-muted small" style="font-size: 0.76rem;">Registered Admin</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark search-target" style="font-size: 0.86rem;">Super Administrator</div>
                                        <span class="dept-tag mt-1">Executive Office</span>
                                    </td>
                                    <td class="search-target">
                                        <a href="mailto:<?php echo e($adminUser->email); ?>" class="text-secondary text-decoration-none small">
                                            <?php echo e($adminUser->email); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted small search-target"><?php echo e($adminUser->phone ?? '—'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-soft-green">
                                            <span class="dot"></span> Active
                                        </span>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                                <!-- Management Team -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $managementTeam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="team-row">
                                    <td class="text-muted fw-semibold"><?php echo e($counter++); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-soft" style="background-color: #ecfdf5; color: #059669;">
                                                <?php echo e(strtoupper(substr($manager['name'], 0, 2))); ?>

                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark search-target"><?php echo e($manager['name']); ?></div>
                                                <div class="text-muted small" style="font-size: 0.76rem;">Staff Manager</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark search-target" style="font-size: 0.86rem;"><?php echo e($manager['role']); ?></div>
                                        <span class="dept-tag mt-1 search-target"><?php echo e($manager['department']); ?></span>
                                    </td>
                                    <td class="search-target">
                                        <a href="mailto:<?php echo e($manager['email']); ?>" class="text-secondary text-decoration-none small">
                                            <?php echo e($manager['email']); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($manager['whatsapp']): ?>
                                            <a href="https://wa.me/<?php echo e($manager['whatsapp']); ?>?text=Hello%20<?php echo e(urlencode($manager['name'])); ?>,%20contacting%20from%20Admin%20Portal" target="_blank" rel="noopener noreferrer" class="btn-wa-compact" title="WhatsApp Chat">
                                                <i class="bi bi-whatsapp"></i> Chat
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-soft-green">
                                            <span class="dot"></span> Active
                                        </span>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: SYSTEM ADMINS ONLY -->
                <div class="tab-pane fade" id="tab-super" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-directory align-middle" id="tableSuper">
                            <thead>
                                <tr>
                                    <th style="width: 45px;">#</th>
                                    <th>Admin Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center" style="width: 100px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $systemAdmins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adminUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="team-row">
                                    <td class="text-muted fw-semibold"><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-soft" style="background-color: #e0f2fe; color: #0284c7;">
                                                <?php echo e(strtoupper(substr($adminUser->name, 0, 2))); ?>

                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark search-target">
                                                    <?php echo e($adminUser->name); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminUser->id === auth()->id()): ?>
                                                        <span class="badge bg-light text-secondary border ms-1" style="font-size: 0.65rem;">You</span>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">Super Administrator</span>
                                    </td>
                                    <td class="search-target">
                                        <a href="mailto:<?php echo e($adminUser->email); ?>" class="text-secondary text-decoration-none small">
                                            <?php echo e($adminUser->email); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-dark small search-target"><?php echo e($adminUser->phone ?? '—'); ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-soft-green">
                                            <span class="dot"></span> Active
                                        </span>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: MANAGERS ONLY -->
                <div class="tab-pane fade" id="tab-managers" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-directory align-middle" id="tableManagers">
                            <thead>
                                <tr>
                                    <th style="width: 45px;">#</th>
                                    <th>Manager Name</th>
                                    <th>Role & Department</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th class="text-center" style="width: 100px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $managementTeam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <tr class="team-row">
                                    <td class="text-muted fw-semibold"><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-soft" style="background-color: #ecfdf5; color: #059669;">
                                                <?php echo e(strtoupper(substr($manager['name'], 0, 2))); ?>

                                            </div>
                                            <div class="fw-bold text-dark search-target"><?php echo e($manager['name']); ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark search-target" style="font-size: 0.86rem;"><?php echo e($manager['role']); ?></div>
                                        <span class="dept-tag mt-1 search-target"><?php echo e($manager['department']); ?></span>
                                    </td>
                                    <td class="search-target">
                                        <a href="mailto:<?php echo e($manager['email']); ?>" class="text-secondary text-decoration-none small">
                                            <?php echo e($manager['email']); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($manager['whatsapp']): ?>
                                            <a href="https://wa.me/<?php echo e($manager['whatsapp']); ?>?text=Hello%20<?php echo e(urlencode($manager['name'])); ?>,%20contacting%20from%20Admin%20Portal" target="_blank" rel="noopener noreferrer" class="btn-wa-compact" title="WhatsApp Chat">
                                                <i class="bi bi-whatsapp"></i> Chat
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-soft-green">
                                            <span class="dot"></span> Active
                                        </span>
                                    </td>
                                </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('quickSearchInput');
        if (!searchInput) return;

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase().trim();
            const activePane = document.querySelector('.tab-pane.active');
            const targetTables = activePane ? [activePane.querySelector('table')] : document.querySelectorAll('.table-directory');

            targetTables.forEach(table => {
                if (!table) return;
                const rows = table.querySelectorAll('tbody .team-row');
                let visibleCount = 0;

                rows.forEach(row => {
                    const targets = row.querySelectorAll('.search-target');
                    let matched = false;

                    if (query === '') {
                        matched = true;
                    } else {
                        targets.forEach(el => {
                            if (el.textContent.toLowerCase().includes(query)) {
                                matched = true;
                            }
                        });
                    }

                    row.style.display = matched ? '' : 'none';
                    if (matched) visibleCount++;
                });

                // Remove existing empty message if any
                const existingEmpty = table.querySelector('.no-results-row');
                if (existingEmpty) existingEmpty.remove();

                if (visibleCount === 0 && query !== '') {
                    const colCount = table.querySelectorAll('thead th').length || 6;
                    const tbody = table.querySelector('tbody');
                    const emptyTr = document.createElement('tr');
                    emptyTr.className = 'no-results-row text-center text-muted py-4';
                    emptyTr.innerHTML = `<td colspan="${colCount}" class="py-4"><i class="bi bi-search text-muted fs-4 d-block mb-1"></i>No members found matching "<strong>${query}</strong>"</td>`;
                    tbody.appendChild(emptyTr);
                }
            });
        });

        // Re-filter when user clicks a tab
        document.querySelectorAll('#adminsTab button[data-bs-toggle="pill"]').forEach(tabBtn => {
            tabBtn.addEventListener('shown.bs.tab', function() {
                if (searchInput.value.trim() !== '') {
                    searchInput.dispatchEvent(new Event('input'));
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/admins.blade.php ENDPATH**/ ?>