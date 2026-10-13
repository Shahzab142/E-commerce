<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4" style="color: #4a5568; font-weight: 600;">Create Reservation</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-muted">New Reservation Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Customer Name</label>
                                    <input type="text" class="form-control bg-light border-0" name="customer_name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Customer Email</label>
                                    <input type="email" class="form-control bg-light border-0" name="customer_email" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">Product / Service</label>
                                <input type="text" class="form-control bg-light border-0" name="product_service" required>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Reservation Date</label>
                                    <input type="date" class="form-control bg-light border-0" name="reservation_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Time</label>
                                    <input type="time" class="form-control bg-light border-0" name="reservation_time" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label text-muted small fw-bold">Additional Notes</label>
                                <textarea class="form-control bg-light border-0" name="notes" rows="3"></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="<?php echo e(route('admin.reservations.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4 fw-bold">Save Reservation</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\reservations\create.blade.php ENDPATH**/ ?>