<?php $__env->startPush('title'); ?>
    <title>Create Order - Employee Portal</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .form-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
            max-width: 550px;
            margin: 0 auto;
        }
        .form-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
        }
        .btn-add-blue {
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
        .btn-add-blue:hover {
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
            <h2 class="fw-bold" style="color: #1e3a8a;">Orders</h2>
        </div>

        <div class="form-card">
            <h6 class="fw-bold text-dark mb-4">Add New Order for Product #<?php echo e($reservation->product_id); ?> (<?php echo e($reservation->product->name ?? 'Product'); ?>)</h6>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="alert alert-danger rounded-3 mb-3">
                    <ul class="mb-0 ps-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><?php echo e($err); ?></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('employee.reservations.order.store', $reservation->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <input type="text" name="order_number" class="form-control" placeholder="Order Number" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="paypal_email" class="form-control" placeholder="Paypal">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="hasPicUrl">
                    <label class="form-check-label text-muted small" for="hasPicUrl">
                        I have order picture URL
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Order Pic</label>
                    <input type="file" name="order_pic" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Refund Pic</label>
                    <input type="file" name="refund_pic" class="form-control">
                </div>

                <div class="mb-4">
                    <input type="url" name="amz_review_link" class="form-control" placeholder="AMZ Review Link">
                </div>

                <button type="submit" class="btn btn-primary btn-add-blue" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-plus-circle me-1"></i> Add Now
                </button>
            </form>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/employee/reservations/create-order.blade.php ENDPATH**/ ?>