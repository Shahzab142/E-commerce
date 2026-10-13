<?php $__env->startSection('content'); ?>
    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h4 class="mb-0 text-dark" style="font-weight: 500;"><i class="bi bi-shield-x me-2 text-danger"></i>Blacklisted PayPal</h4>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addBlacklistModal">
                    <i class="bi bi-plus-circle me-1"></i> Add New
                </button>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="fw-bold mb-0">Blacklisted Emails List</h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th>#</th>
                                <th>Email Address</th>
                                <th>Reason</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Demo Data -->
                            <tr>
                                <td>1</td>
                                <td>scammer@example.com</td>
                                <td>Fraudulent activity</td>
                                <td>2023-10-15</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>badbuyer@test.com</td>
                                <td>Multiple chargebacks</td>
                                <td>2023-10-20</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addBlacklistModal" tabindex="-1" aria-labelledby="addBlacklistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBlacklistModalLabel">Add Blacklisted PayPal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">PayPal Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <textarea class="form-control" name="reason" rows="3" required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">Blacklist</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\paypal\index.blade.php ENDPATH**/ ?>