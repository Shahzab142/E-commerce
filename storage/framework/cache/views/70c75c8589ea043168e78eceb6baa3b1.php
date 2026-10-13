<?php $__env->startPush('title'); ?>
    <title>Change Password - Employee Portal</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .password-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 520px;
            margin: 0 auto;
        }
        .password-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            font-size: 0.95rem;
        }
        .btn-update-now {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            padding: 12px 28px !important;
            border-radius: 8px !important;
            transition: all 0.25s ease-in-out !important;
            letter-spacing: 0.3px !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;
        }
        .btn-update-now:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45) !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Change Password</h2>
        </div>

        <div class="password-card">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($err); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-1">Update Password</h6>
                <p class="text-muted small mb-0">
                    Your password must be more than 6 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
                </p>
            </div>

            <form action="<?php echo e(route('employee.change-password.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                </div>

                <div class="mb-4">
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Type Again New Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-update-now" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-shield-lock me-1"></i> Update Now
                </button>
            </form>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\change-password.blade.php ENDPATH**/ ?>