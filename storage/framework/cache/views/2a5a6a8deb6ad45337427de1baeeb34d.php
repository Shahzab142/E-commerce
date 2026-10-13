<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Welcome Aboard
    <?php $__env->endSlot(); ?>

    <h2>Thanks for Subscribing!</h2>
    <p>You’re now part of the <strong><?php echo e($appName ?? 'Shop Hub'); ?></strong> community. Get ready for exclusive deals, new arrivals, and special discounts delivered straight to your inbox.</p>

    <div class="card">
        <div class="info-row">
            <span class="info-label">Subscribed Email</span>
            <span class="info-value"><?php echo e($email); ?></span>
        </div>
    </div>

    <a href="<?php echo e(route('shop')); ?>" class="btn">Start Shopping</a>

    <p>Stay tuned for amazing offers!</p>

    Thanks,<br>
    <strong><?php echo e($appName ?? 'Shop Hub'); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\newsletter-subscriber.blade.php ENDPATH**/ ?>