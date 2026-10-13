<?php $__env->startPush('title'); ?>
    <title>Check Blacklisted Paypal - Employee Portal</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .paypal-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 600px;
            margin: 0 auto;
        }
        .paypal-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
        }
        .btn-check-paypal {
            background-color: #003087;
            color: #ffffff;
            border: none;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-check-paypal:hover {
            background-color: #002266;
            color: #ffffff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Check Blacklisted Paypal</h2>
        </div>

        <div class="paypal-card">
            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="bi bi-paypal fs-1" style="color: #003087;"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-1">Verify Buyer PayPal</h5>
                    <p class="text-muted small mb-0">Check if a customer's PayPal email has been blacklisted for chargebacks or scams.</p>
                </div>
            </div>

            <form action="<?php echo e(route('employee.paypal.blacklisted')); ?>" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="email" name="paypal_email" class="form-control" placeholder="Enter PayPal Email (e.g. buyer@example.com)" value="<?php echo e(request('paypal_email')); ?>" required>
                    <button type="submit" class="btn btn-check-paypal">Check Now</button>
                </div>
            </form>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($isBlacklisted)): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isBlacklisted): ?>
                    <div class="alert alert-danger rounded-3 p-4 text-center">
                        <i class="bi bi-shield-x fs-1 d-block mb-2 text-danger"></i>
                        <h5 class="fw-bold text-danger">WARNING: Blacklisted Account</h5>
                        <p class="mb-1"><strong><?php echo e($search); ?></strong> is in the blacklisted database.</p>
                        <small class="text-muted">Reason: <?php echo e($reason); ?></small>
                    </div>
                <?php else: ?>
                    <div class="alert alert-success rounded-3 p-4 text-center">
                        <i class="bi bi-shield-check fs-1 d-block mb-2 text-success"></i>
                        <h5 class="fw-bold text-success">Account is Clean</h5>
                        <p class="mb-0">No fraud or blacklist records found for <strong><?php echo e($search); ?></strong>.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/employee/paypal-blacklist.blade.php ENDPATH**/ ?>