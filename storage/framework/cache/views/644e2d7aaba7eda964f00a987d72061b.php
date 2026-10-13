<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        New Registration Alert
    <?php $__env->endSlot(); ?>

    <h2>New Registration Received</h2>
    <p>Hello Admin, a new account has just been created on <strong><?php echo e($appName ?? 'Shop Hub'); ?></strong>. Here are the details:</p>

    <div class="card">
        <div class="info-row">
            <span class="info-label">Name</span>
            <span class="info-value"><?php echo e($userName ?? 'N/A'); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value"><?php echo e($userEmail ?? 'N/A'); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value"><span class="badge"><?php echo e($roleLabel ?? 'User'); ?></span></span>
        </div>
        <div class="info-row">
            <span class="info-label">Registered</span>
            <span class="info-value"><?php echo e($registrationTime ?? 'Recently'); ?></span>
        </div>
    </div>

    <p style="margin-top: 22px;">You can review this account from your admin dashboard.</p>

    <a href="<?php echo e(url('/admin')); ?>" class="btn">Go to Admin Dashboard</a>

    Thanks,<br>
    <strong><?php echo e($appName ?? 'Shop Hub'); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\signup-notification.blade.php ENDPATH**/ ?>