<?php echo e($appName ?? 'Shop Hub'); ?> - Verification Code

Hello,

Your verification code is: <?php echo e($code); ?>


This code will expire in <?php echo e($expiresAt); ?>.

Context: <?php echo e($context === 'signup' ? 'Sign-up verification' : 'Other'); ?>


If you did not request this code, simply ignore this email.

Thanks,
<?php echo e($appName ?? 'The Team'); ?>

<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\verification-code-text.blade.php ENDPATH**/ ?>