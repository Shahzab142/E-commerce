<?php $__env->startPush('title'); ?>
    <title>Create Excel Report - Employee Portal</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .excel-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 520px;
            margin: 0 auto;
        }
        .excel-card .form-control, .excel-card .form-select {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 0.95rem;
        }
        .btn-generate-excel {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: none !important;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: 9999px;
            transition: all 0.25s ease-in-out;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }
        .btn-generate-excel:hover {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
        }
        .btn-generate-excel:active {
            transform: translateY(0);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Create Excel</h2>
        </div>

        <div class="excel-card text-center">
            <div class="mb-4">
                <i class="bi bi-file-earmark-excel text-success" style="font-size: 3.5rem;"></i>
                <h5 class="fw-bold text-dark mt-2 mb-1">Export Excel Report</h5>
                <p class="text-muted small mb-0">Generate a custom excel report based on date and order status.</p>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="alert alert-danger rounded-3 text-start mb-4">
                    <i class="bi bi-exclamation-circle me-1"></i> <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('employee.excel.generate')); ?>" method="POST" class="text-start">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="from_date" class="form-label text-muted small fw-bold">From Date</label>
                    <input type="date" class="form-control" id="from_date" name="from_date" required>
                </div>

                <div class="mb-3">
                    <label for="to_date" class="form-label text-muted small fw-bold">To Date</label>
                    <input type="date" class="form-control" id="to_date" name="to_date" required>
                </div>

                <div class="mb-4">
                    <label for="order_status" class="form-label text-muted small fw-bold">Order Status</label>
                    <select class="form-select" id="order_status" name="order_status">
                        <option value="" selected>All Statuses</option>
                        <option value="ordered">Ordered</option>
                        <option value="reviewed">Reviewed</option>
                        <option value="review_submitted_refund">Review Submitted Pending Refund</option>
                        <option value="review_deleted">Review Deleted</option>
                        <option value="refunded">Refunded</option>
                        <option value="on_hold">On Hold</option>
                        <option value="refunded_pending_review">Refunded Pending Review</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-generate-excel" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 24px !important; border-radius: 9999px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                        <i class="bi bi-file-earmark-arrow-down me-1"></i> GENERATE
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\excel.blade.php ENDPATH**/ ?>