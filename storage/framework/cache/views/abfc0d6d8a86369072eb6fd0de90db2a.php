<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Account Security
    <?php $__env->endSlot(); ?>

    <h2>Reset Your Password</h2>
    <p>We received a request to reset the password for your <strong><?php echo e($appName ?? config('app.name', 'Shop Hub')); ?></strong> account.</p>

    <p>Click the button below to choose a new password:</p>

    <a href="<?php echo e($url); ?>" class="btn">Reset Password</a>

    <p>This password reset link will expire in <strong>60 minutes</strong>.</p>
    <p>If you did not request a password reset, you can safely ignore this email. Your password will not be changed.</p>

    Thanks,<br>
    <strong><?php echo e($appName ?? config('app.name', 'Shop Hub')); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\forgot-password.blade.php ENDPATH**/ ?>