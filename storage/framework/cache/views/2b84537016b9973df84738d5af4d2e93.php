<?php $__env->startPush('title'); ?>
    <title>Reserved Orders - Employee Portal</title>
    <style>
        .res-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .timer-badge {
            color: #ef4444;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            font-family: monospace;
        }
        .img-thumb-res {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .btn-create-order {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-create-order:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .btn-release {
            background-color: #be123c;
            color: #ffffff;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 6px;
        }
        .btn-release:hover {
            background-color: #9f1239;
            color: #ffffff;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Reserved Orders</h2>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="res-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark">Active Reservations</h5>
                <a href="<?php echo e(route('employee.reservations.create')); ?>" class="btn btn-sm btn-success rounded-pill px-3">
                    <i class="bi bi-plus-circle me-1"></i> Add Reservation
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Product ID</th>
                            <th>Remaining Time</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $img = $res->product?->images->first()?->image;
                            $imgUrl = $img ? asset('storage/' . $img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200';
                            $targetTimestamp = $res->expires_at ? \Carbon\Carbon::parse($res->expires_at)->timestamp : now()->addHours(2)->timestamp;
                        ?>
                        <tr>
                            <td class="text-muted">2206087<?php echo e($res->id); ?></td>
                            <td class="fw-semibold text-dark"><?php echo e($res->user->name ?? 'Employee'); ?></td>
                            <td class="fw-bold text-primary">#<?php echo e($res->product_id); ?></td>
                            <td>
                                <span class="timer-badge countdown-timer" data-expire="<?php echo e($targetTimestamp); ?>">
                                    1:28:20
                                </span>
                            </td>
                            <td>
                                <img src="<?php echo e($imgUrl); ?>" alt="Product" class="img-thumb-res">
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('employee.reservations.order.create', $res->id)); ?>" class="btn btn-create-order">
                                        <i class="bi bi-cart-plus me-1"></i> Create Order
                                    </a>

                                    <button type="button" class="btn btn-release" data-bs-toggle="modal" data-bs-target="#releaseModal<?php echo e($res->id); ?>">
                                        <i class="bi bi-x me-1"></i> Release
                                    </button>
                                </div>

                                <!-- Confirm Delete Modal Matching Video -->
                                <div class="modal fade" id="releaseModal<?php echo e($res->id); ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-danger text-white py-2">
                                                <h6 class="modal-title fw-bold">Confirm Delete</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <h5 class="fw-bold text-dark mb-2">Warning !!!</h5>
                                                <p class="text-muted mb-0">Do you wish to proceed with Release?</p>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 pb-4">
                                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">NO</button>
                                                <form action="<?php echo e(route('employee.reservations.release', $res->id)); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger px-4 rounded-pill">YES</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
                                No active reservations found.
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script>
    // Live countdown timer script
    function updateTimers() {
        const timerEls = document.querySelectorAll('.countdown-timer');
        const now = Math.floor(Date.now() / 1000);

        timerEls.forEach(el => {
            const expire = parseInt(el.getAttribute('data-expire'), 10);
            let diff = expire - now;

            if (diff <= 0) {
                el.innerText = '0:00:00 (Expired)';
                el.classList.add('text-muted');
                return;
            }

            const hours = Math.floor(diff / 3600);
            const minutes = Math.floor((diff % 3600) / 60);
            const seconds = diff % 60;

            el.innerText = `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        });
    }

    setInterval(updateTimers, 1000);
    updateTimers();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\reservations\index.blade.php ENDPATH**/ ?>