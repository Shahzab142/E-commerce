<?php $__env->startPush('title'); ?>
    <title>Active Admins - Employee Portal</title>
    <style>
        .admins-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
        }
        .btn-wa {
            background-color: #22c55e;
            color: #ffffff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .btn-wa:hover {
            background-color: #16a34a;
            color: #ffffff;
            transform: scale(1.08);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-2" style="max-width: 900px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Admins</h2>
        </div>

        <div class="admins-card">
            <h5 class="fw-bold mb-4 text-dark">Active Admins</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th style="width: 100px;" class="text-center">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?php echo e($admin['id']); ?></td>
                            <td class="fw-bold text-dark"><?php echo e($admin['name']); ?></td>
                            <td>
                                <span class="badge bg-light text-secondary border px-3 py-2 fs-6 fw-medium text-wrap text-start">
                                    <?php echo e($admin['role']); ?>

                                </span>
                            </td>
                            <td class="text-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($admin['whatsapp']): ?>
                                    <a href="https://wa.me/<?php echo e($admin['whatsapp']); ?>" target="_blank" class="btn-wa" title="Contact on WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">none</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\admins.blade.php ENDPATH**/ ?>