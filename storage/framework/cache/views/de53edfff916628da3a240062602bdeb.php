<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Profile Update Confirmation
    <?php $__env->endSlot(); ?>

    <h2>Your Profile Was Updated</h2>
    <p>Hello <strong><?php echo new \Illuminate\Support\EncodedHtmlString($userName ?? 'there'); ?></strong>, this is a confirmation that your profile was updated successfully.</p>

    <div class="card">
        <div class="section-title">Updated Fields</div>
        <div class="info-row">
            <span class="info-label">Changes</span>
            <span class="info-value"><?php echo new \Illuminate\Support\EncodedHtmlString($updatedFields ?? 'Profile information'); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Updated At</span>
            <span class="info-value"><?php echo new \Illuminate\Support\EncodedHtmlString($updateTime ?? now()->format('F j, Y \\a\\t g:i A')); ?></span>
        </div>
    </div>

    <p>If you did not make this change, please contact us immediately so we can secure your account.</p>

    Thanks,<br>
    <strong><?php echo new \Illuminate\Support\EncodedHtmlString($appName ?? 'Shop Hub'); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/emails/profile-updated.blade.php ENDPATH**/ ?>