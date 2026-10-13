<?php $__env->startPush('title'); ?>
    <title>Products - Khyber Pro</title>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .metric-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            padding: 16px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
            height: 100%;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }
        .metric-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #ffffff;
            font-size: 1.15rem;
        }
        .metric-content {
            flex: 1;
            min-width: 0;
        }
        .metric-number {
            font-size: 1.55rem;
            font-weight: 800;
            line-height: 1.1;
            color: #004b49;
            margin-bottom: 2px;
        }
        .metric-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 0;
        }
        .card-clean {
            border: 1px solid #eef2f6;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        /* Seamless Modern Table (Zero Vertical Borders) */
        .datatable-top {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 16px 22px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background: #ffffff !important;
            gap: 12px !important;
            flex-wrap: wrap !important;
        }
        .datatable-top > div:first-child {
            float: none !important;
            display: flex !important;
            align-items: center !important;
            font-size: 0.82rem !important;
            color: #64748b !important;
        }
        .datatable-top > div:last-child {
            float: none !important;
        }
        .datatable-selector {
            border-radius: 20px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            padding: 5px 26px 5px 12px !important;
            font-size: 0.82rem !important;
            color: #334155 !important;
            font-weight: 500 !important;
            margin-right: 6px !important;
        }
        .datatable-input {
            border-radius: 20px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            padding: 7px 18px !important;
            font-size: 0.84rem !important;
            color: #0f172a !important;
            min-width: 220px !important;
            transition: all 0.15s ease !important;
        }
        .datatable-input:focus, .datatable-selector:focus {
            background-color: #ffffff !important;
            border-color: #16a34a !important;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12) !important;
            outline: none !important;
        }

        /* STRICTLY REMOVE ALL VERTICAL BORDERS */
        .datatable-table,
        .datatable-table > thead > tr > th,
        .datatable-table > tbody > tr > td,
        .table > thead > tr > th,
        .table > tbody > tr > td {
            border-left: none !important;
            border-right: none !important;
            border-top: none !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }
        .datatable-table {
            border-collapse: collapse !important;
            width: 100% !important;
            margin-bottom: 0 !important;
        }
        .datatable-table > thead > tr > th,
        .table > thead > tr > th {
            font-size: 0.74rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            font-weight: 700 !important;
            color: #64748b !important;
            background-color: #f8fafc !important;
            padding: 14px 20px !important;
        }
        .datatable-sorter {
            font-size: 0.74rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            font-weight: 700 !important;
            color: #64748b !important;
            padding: 0 !important;
            background: transparent !important;
            border: none !important;
        }
        .datatable-sorter:hover {
            color: #0f172a !important;
        }
        .datatable-table > tbody > tr > td,
        .table > tbody > tr > td {
            padding: 14px 20px !important;
            vertical-align: middle !important;
        }
        .datatable-table tbody tr {
            transition: background-color 0.15s ease !important;
        }
        .datatable-table tbody tr:hover {
            background-color: #f8fafc !important;
        }

        .datatable-bottom {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 14px 22px !important;
            border-top: 1px solid #f1f5f9 !important;
            font-size: 0.82rem !important;
            color: #64748b !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
        }
        .datatable-bottom > nav:last-child {
            float: none !important;
        }
        .datatable-info {
            margin: 0 !important;
        }
        .datatable-pagination a {
            border-radius: 8px !important;
            padding: 5px 11px !important;
            margin: 0 2px !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            border: 1px solid #e2e8f0 !important;
        }
        .datatable-pagination .active a {
            background-color: #16a34a !important;
            border-color: #16a34a !important;
            color: #ffffff !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main style="background-color: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-3 px-md-4 py-4 pb-5">

        
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Products</h2>
                <p class="text-muted small mb-0">Manage catalog inventory, pricing, and stock status</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="<?php echo e(route('admin.products.add')); ?>" class="btn btn-success rounded-pill px-3 py-2 fw-semibold shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                </a>
                <a href="<?php echo e(route('admin.products.export')); ?>" class="btn btn-outline-success rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #14532d;">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($products->count())); ?></div>
                        <div class="metric-title">Total Products</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #16a34a;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($products->where('quantity', '>', 0)->count())); ?></div>
                        <div class="metric-title">In Stock</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #dc2626;">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($products->where('quantity', '<=', 0)->count())); ?></div>
                        <div class="metric-title">Out of Stock</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="metric-card">
                    <div class="metric-icon-box" style="background-color: #0284c7;">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number"><?php echo e(number_format($products->pluck('category_id')->filter()->unique()->count())); ?></div>
                        <div class="metric-title">Active Categories</div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card card-clean">
            <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="bi bi-grid-3x3-gap-fill text-success me-2"></i> Product Catalog
                </h5>
                <span class="badge bg-light text-muted border px-3 py-1.5 rounded-pill fw-semibold"><?php echo e($products->count()); ?> items</span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width="75">Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Vendor</th>
                            <th class="text-end pe-4" style="min-width: 240px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <tr>
                                
                                <td>
                                    <?php $productImage = $prod->images->first(); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($productImage): ?>
                                        <img src="<?php echo e(asset('storage/' . $productImage->image)); ?>"
                                             class="rounded-3 border" width="42" height="42"
                                             style="object-fit: cover;" alt="<?php echo e($prod->name); ?>">
                                    <?php else: ?>
                                        <div class="rounded-3 bg-light border d-flex align-items-center justify-content-center text-muted" style="width: 42px; height: 42px;">
                                            <i class="bi bi-image text-secondary opacity-50 fs-5"></i>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.92rem;"><?php echo e($prod->name); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->sku): ?>
                                        <div class="text-muted font-monospace small" style="font-size: 0.76rem;">
                                            SKU: <?php echo e($prod->sku); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <span class="badge rounded-pill fw-semibold" style="background-color: #f1f5f9; color: #475569; font-size: 0.78rem; padding: 5px 12px;">
                                        <?php echo e($prod->category->name ?? 'Uncategorized'); ?>

                                    </span>
                                </td>

                                
                                <td>
                                    <div class="fw-bold text-dark" style="font-size: 0.92rem;">
                                        Rs. <?php echo e(number_format($prod->sale_price ?? $prod->regular_price, 2)); ?>

                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->sale_price): ?>
                                        <small class="text-muted text-decoration-line-through d-block" style="font-size: 0.74rem;">
                                            Rs. <?php echo e(number_format($prod->regular_price, 2)); ?>

                                        </small>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->quantity > 0): ?>
                                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill fw-semibold" style="font-size: 0.78rem; padding: 5px 12px;">
                                            <i class="bi bi-check-circle-fill me-1"></i> <?php echo e($prod->quantity); ?> in stock
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill fw-semibold" style="font-size: 0.78rem; padding: 5px 12px;">
                                            <i class="bi bi-x-circle-fill me-1"></i> Out of stock
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($prod->vendor): ?>
                                        <a href="<?php echo e(route('admin.vendors.show', ['user' => $prod->vendor->id])); ?>" class="fw-semibold text-primary text-decoration-none" style="font-size: 0.85rem;">
                                            <i class="bi bi-shop me-1 text-muted"></i> <?php echo e($prod->vendor->name); ?>

                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small" style="font-size: 0.82rem;">
                                            <i class="bi bi-shield-check text-success me-1"></i> Store Direct
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>

                                
                                <td class="text-end pe-4 text-nowrap" style="min-width: 240px;">
                                    <div class="d-inline-flex align-items-center gap-2">
                                        <a href="<?php echo e(route('admin.products.show', $prod->id)); ?>"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-1 fw-semibold text-nowrap"
                                           style="font-size: 0.78rem;" title="View Product">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>

                                        <a href="<?php echo e(route('admin.products.edit', $prod->id)); ?>"
                                           class="btn btn-sm btn-outline-warning rounded-pill px-2.5 py-1 fw-semibold text-nowrap"
                                           style="font-size: 0.78rem;" title="Edit Product">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </a>

                                        <form action="<?php echo e(route('admin.products.delete', $prod->id)); ?>" method="POST"
                                              class="d-inline mb-0"
                                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fw-semibold text-nowrap"
                                                    style="font-size: 0.78rem;" title="Delete Product">
                                                <i class="bi bi-trash3 me-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-box-seam display-4 d-block mb-2 text-secondary opacity-50"></i>
                                    <p class="mb-2">No products found in catalog.</p>
                                    <a href="<?php echo e(route('admin.products.add')); ?>" class="btn btn-sm btn-success rounded-pill px-3">
                                        <i class="bi bi-plus-circle me-1"></i> Add Your First Product
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

<?php echo $__env->make('admin.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\view-product.blade.php ENDPATH**/ ?>