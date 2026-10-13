<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Secure Verification
    <?php $__env->endSlot(); ?>

    <h2>Your Verification Code</h2>
    <p>Hello, please use the verification code below <?php echo e($context === 'signup' ? 'to complete your sign-up' : 'to proceed with your request'); ?>:</p>

    <div class="code-box">
        <?php echo e($code); ?>

    </div>

    <p>This code will expire in <strong><?php echo e($expiresAt); ?></strong>. If you did not request this code, you can safely ignore this email.</p>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($context === 'reset'): ?>
        <a href="<?php echo e(url('reset-password')); ?>" class="btn">Reset Password</a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    Thanks,<br>
    <strong><?php echo e($appName ?? 'Shop Hub'); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\verification-code.blade.php ENDPATH**/ ?>