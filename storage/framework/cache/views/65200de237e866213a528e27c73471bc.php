

<?php $__env->startPush('title'); ?>
    <title>Categories Management - Admin</title>
    <style>
        .admin-page-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #eaedf1;
        }
        .admin-card {
            background-color: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .admin-card-header {
            background-color: #fff;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f3f5;
        }
        .admin-table th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 1.5rem;
            border-bottom: 2px solid #eaedf1;
            white-space: nowrap;
        }
        .admin-table td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            color: #3b4252;
            border-bottom: 1px solid #f1f3f5;
            white-space: nowrap;
        }
        .admin-table tbody tr {
            transition: all 0.2s ease;
        }
        .admin-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }
        .status-badge {
            padding: 0.5em 1em;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 30px;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        .status-published { background-color: #d4edda; color: #155724; }
        .status-draft { background-color: #fff3cd; color: #856404; }
        .status-hidden { background-color: #e2e3e5; color: #383d41; }
        
        .btn-action {
            border-radius: 20px;
            padding: 0.375rem 0.75rem;
            transition: all 0.2s;
        }
        .cat-slug {
            font-family: monospace;
            background: #f1f3f5;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
            color: #d63384;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div id="layoutSidenav_content">
        <main class="bg-light pb-5" style="min-height: 100vh;">
            <div class="container-fluid px-4 py-4">
                
                <div class="admin-page-header d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1 class="h3 fw-bold mb-1 text-dark">
                            <i class="bi bi-tags-fill text-primary me-2"></i>Categories Overview
                        </h1>
                        <p class="text-muted mb-0">Manage the categories your products are organized under.</p>
                    </div>
                    <div class="mt-3 mt-md-0 d-flex gap-2">
                        <a href="<?php echo e(route('admin.categories.export')); ?>" class="btn btn-outline-success rounded-pill px-4">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                        </a>
                        <a href="<?php echo e(route('admin.categories.add')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-plus-circle me-2"></i>Add Category
                        </a>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                    <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                    <div class="alert alert-danger shadow-sm border-0 rounded-3 mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e(session('error')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="admin-card">
                    <div class="admin-card-header d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-list-ul me-2 text-primary"></i>Category List
                        </h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table admin-table mb-0" id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Category Name</th>
                                    <th>Short Description</th>
                                    <th>Slug</th>
                                    <th>Products</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <tr>
                                        <td>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $cat->image)); ?>" alt="<?php echo e($cat->name); ?>" class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded shadow-sm bg-light d-flex align-items-center justify-content-center text-muted" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="fw-bold mb-0 text-dark"><?php echo e($cat->name); ?></h6>
                                        </td>
                                        <td>
                                            <div class="text-truncate text-muted" style="max-width: 200px;" title="<?php echo e($cat->short_description ?? 'No description'); ?>">
                                                <?php echo e($cat->short_description ?? 'No description'); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <span class="cat-slug"><?php echo e($cat->slug); ?></span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary rounded-pill px-3 py-2"><?php echo e($cat->products_count ?? '18'); ?> items</span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo e($cat->status === 'published' ? 'published' : ($cat->status === 'draft' ? 'draft' : 'hidden')); ?>">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat->status === 'published'): ?> <i class="bi bi-check-circle me-1"></i> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat->status === 'draft'): ?> <i class="bi bi-pencil me-1"></i> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat->status !== 'published' && $cat->status !== 'draft'): ?> <i class="bi bi-eye-slash me-1"></i> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php echo e(ucfirst($cat->status)); ?>

                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="<?php echo e(route('admin.categories.show', $cat->id)); ?>" class="btn btn-outline-primary btn-action" title="View Category">
                                                    <i class="bi bi-eye me-1"></i> View
                                                </a>
                                                <a href="<?php echo e(route('admin.categories.edit', $cat->id)); ?>" class="btn btn-outline-warning btn-action" title="Edit Category">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </a>
                                                <form action="<?php echo e(route('admin.categories.delete', $cat->id)); ?>" method="POST" class="m-0" onsubmit="return confirm('Are you sure you want to delete <?php echo e($cat->name); ?>? This action cannot be undone.');">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-action" title="Delete Category">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted mb-3">
                                                <i class="bi bi-folder-x fs-1"></i>
                                            </div>
                                            <h5 class="fw-bold">No Categories Found</h5>
                                            <p class="text-muted">You haven't created any categories yet.</p>
                                            <a href="<?php echo e(route('admin.categories.add')); ?>" class="btn btn-primary rounded-pill px-4 mt-2">
                                                <i class="bi bi-plus-circle me-2"></i>Add Category
                                            </a>
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

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\view-category.blade.php ENDPATH**/ ?>