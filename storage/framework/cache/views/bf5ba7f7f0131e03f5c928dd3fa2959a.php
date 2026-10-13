<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    <h1 class="mt-4 mb-4 text-center" style="color: #4a5568; font-weight: 600;">User Message Broadcast</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <form action="<?php echo e(route('admin.user-message.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label text-muted small fw-bold">Message Text</label>
                            <textarea class="form-control bg-light border-0" id="message" name="message" rows="4" placeholder="Enter the message you want to display on the user dashboard..."><?php echo e($userMessage->message ?? ''); ?></textarea>
                        </div>
                        
                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php echo e(($userMessage->is_active ?? false) ? 'checked' : ''); ?>>
                            <label class="form-check-label fw-bold" for="is_active">Enable this message?</label>
                            <div class="form-text">If enabled, this message will be visible to all users on their dashboard.</div>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-bold" style="border-radius: 4px;">Save Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/user-message/index.blade.php ENDPATH**/ ?>