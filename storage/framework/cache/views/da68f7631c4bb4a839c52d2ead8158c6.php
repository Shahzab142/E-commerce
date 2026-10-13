

<?php $__env->startPush('title'); ?>
    <title>Users</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div>
                        <h2 class="fw-bold mb-1"><i class="bi bi-people me-2 text-primary"></i>Users</h2>
                        <p class="text-muted mb-0">Manage all registered customers and their accounts.</p>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e(route('admin.users.export')); ?>" class="btn btn-outline-success me-2">
                            <i class="bi bi-file-earmark-excel me-2"></i>
                            Export Excel
                        </a>
                        <button type="button" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus me-1"></i>
                            Add User
                        </button>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Users</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['total']); ?></div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i
                                        class="bi bi-people-fill"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Active</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['active']); ?></div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i
                                        class="bi bi-person-check"></i></div>
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
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i
                                        class="bi bi-person-exclamation"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Blocked</div>
                                    <div class="fw-bold fs-5 mt-2"><?php echo e($stats['blocked']); ?></div>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3"><i
                                        class="bi bi-person-x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">All Users</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="ps-4">User</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Joined</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->image): ?>
                                                        <img src="<?php echo e(asset('storage/' . $user->image)); ?>" alt="<?php echo e($user->name); ?>"
                                                             class="rounded-circle me-2"
                                                             style="width: 36px; height: 36px; object-fit: cover;">
                                                    <?php else: ?>
                                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2"
                                                             style="width: 36px; height: 36px; font-weight: 600;">
                                                            <?php echo e(mb_substr($user->name, 0, 2)); ?>

                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <div class="fw-semibold"><?php echo e($user->name); ?></div>
                                                </div>
                                            </td>
                                            <td class="text-muted small"><?php echo e($user->email); ?></td>
                                            <td><?php echo e($user->phone ?? 'Not provided'); ?></td>
                                            <td><?php echo e($user->created_at?->format('M d, Y') ?? 'N/A'); ?></td>
                                            <td>
                                                <?php
                                                    $statusClass = match ($user->status) {
                                                        'active' => 'success',
                                                        'pending' => 'warning',
                                                        'suspended', 'suspend' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                ?>
                                                <span
                                                    class="badge bg-<?php echo e($statusClass); ?>-subtle text-<?php echo e($statusClass); ?> text-capitalize"><?php echo e($user->status); ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <form action="<?php echo e(route('admin.users.status', $user)); ?>" method="POST"
                                                    class="d-inline-flex align-items-center gap-2">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PATCH'); ?>
                                                    <label class="visually-hidden"
                                                        for="user-status-<?php echo e($user->id); ?>">Status</label>
                                                    <select id="user-status-<?php echo e($user->id); ?>" name="status"
                                                        class="form-select form-select-sm rounded-3"
                                                        onchange="this.form.submit()">
                                                        <option value="active" <?php if($user->status === 'active'): echo 'selected'; endif; ?>>Active</option>
                                                        <option value="pending" <?php if($user->status === 'pending'): echo 'selected'; endif; ?>>Pending
                                                        </option>
                                                        <option value="suspend" <?php if(in_array($user->status, ['suspend', 'suspended'], true)): echo 'selected'; endif; ?>>Blocked
                                                        </option>
                                                    </select>
                                                </form>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($user->status, ['suspend', 'suspended'], true)): ?>
                                                    <form action="<?php echo e(route('admin.users.delete', $user)); ?>" method="POST"
                                                        class="d-inline ms-1"
                                                        onsubmit="return confirm('This will permanently delete this user. Are you sure?');">
                                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                                        </tr>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus me-2"></i> Add New Employee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.employees.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control bg-light" id="name" name="name" required placeholder="e.g. John Doe">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control bg-light" id="email" name="email" required placeholder="e.g. john@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Temporary Password</label>
                            <input type="text" class="form-control bg-light" id="password" name="password" required minlength="6" placeholder="Must be at least 6 characters">
                            <div class="form-text">Share these details with the employee so they can log in.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Create Employee Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\users.blade.php ENDPATH**/ ?>