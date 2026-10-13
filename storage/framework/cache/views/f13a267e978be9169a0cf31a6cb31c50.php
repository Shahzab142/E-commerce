<?php $__env->startPush('title'); ?>
    <title>Products - Employee Portal</title>
    <style>
        .filter-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
        }
        .filter-card .form-control, .filter-card .form-select {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.9rem;
        }
        .btn-search-blue {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-search-blue:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .products-table-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .product-img-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .btn-reserve {
            background-color: #22c55e;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-reserve:hover {
            background-color: #16a34a;
            color: #ffffff;
        }
        .btn-view-blue {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-view-blue:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .btn-fav {
            background-color: #f59e0b;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
        }
        .btn-fav:hover {
            background-color: #d97706;
            color: #ffffff;
        }
        .btn-fav.active {
            background-color: #dc2626;
        }
        .copy-btn {
            cursor: pointer;
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 6px 10px;
            transition: all 0.15s;
        }
        .copy-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Products</h2>
            <p class="text-muted">Category: <span class="badge bg-success text-uppercase"><?php echo e(str_replace('-', ' ', $currentCategory)); ?></span></p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('info')): ?>
            <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> <?php echo e(session('info')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Filter Box Matching Video -->
        <div class="filter-card">
            <form action="<?php echo e(route('employee.products', $currentCategory)); ?>" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="product_code" class="form-control" placeholder="Search by product code..." value="<?php echo e(request('product_code')); ?>">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="market">
                            <option value="">Select Market</option>
                            <option value="US" <?php echo e(request('market') === 'US' ? 'selected' : ''); ?>>US</option>
                            <option value="UK" <?php echo e(request('market') === 'UK' ? 'selected' : ''); ?>>UK</option>
                            <option value="FR" <?php echo e(request('market') === 'FR' ? 'selected' : ''); ?>>FR</option>
                            <option value="AUS" <?php echo e(request('market') === 'AUS' ? 'selected' : ''); ?>>AUS</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Search by keyword..." value="<?php echo e(request('keyword')); ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-search-blue w-100">
                            <i class="fas fa-search me-1"></i> Search Products
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Products Table (Laptop/Desktop View) -->
        <div class="products-table-card">
            <h5 class="fw-bold mb-4 text-dark">Active Products</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Seller</th>
                            <th>Market</th>
                            <th>Sale Limit</th>
                            <th>Today Remaining</th>
                            <th>Total Remaining</th>
                            <th>Commission</th>
                            <th>Keyword</th>
                            <th>Available Refund</th>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Copy Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <?php
                            $isFav = in_array($product->id, $favorites);
                            $img = $product->images->first()?->image;
                            $imgUrl = $img ? asset('storage/' . $img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200';
                            $copyText = "Product ID: {$product->id}\nTitle: {$product->name}\nPrice: $" . number_format($product->sale_price ?? $product->regular_price ?? 0, 2) . "\nSKU: {$product->sku}";
                        ?>
                        <tr>
                            <td>
                                <a href="https://wa.me/923001234567" target="_blank" class="btn btn-sm btn-outline-success rounded-circle p-1" title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <small class="text-muted d-block mt-1">563</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">US</span></td>
                            <td class="fw-semibold">2</td>
                            <td class="text-success fw-bold">2</td>
                            <td class="text-primary fw-bold"><?php echo e($product->quantity ?? 10); ?></td>
                            <td class="fw-bold text-dark">$<?php echo e(number_format((float)($product->regular_price * 0.1), 2)); ?></td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 140px;" title="<?php echo e($product->name); ?>">
                                    <?php echo e($product->name); ?>

                                </span>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary border">Paypal</span></td>
                            <td class="fw-bold text-secondary">#<?php echo e($product->id); ?></td>
                            <td>
                                <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($product->name); ?>" class="product-img-thumb">
                            </td>
                            <td>
                                <button type="button" class="copy-btn" onclick="navigator.clipboard.writeText(`<?php echo e(addslashes($copyText)); ?>`); alert('Product info copied to clipboard!');" title="Copy Info">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <form action="<?php echo e(route('employee.reservations.store')); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <button type="submit" class="btn btn-reserve">
                                            Reserve Now
                                        </button>
                                    </form>

                                    <a href="<?php echo e(route('employee.product.detail', $product->id)); ?>" class="btn btn-view-blue">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>

                                    <form action="<?php echo e(route('employee.product.favorite.toggle', $product->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-fav <?php echo e($isFav ? 'active' : ''); ?>" title="<?php echo e($isFav ? 'Remove Favorite' : 'Add Favorite'); ?>">
                                            <i class="bi <?php echo e($isFav ? 'bi-star-fill' : 'bi-star'); ?>"></i> Favorite
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-2 d-block mb-2 text-secondary"></i>
                                No products found in this category.
                            </td>
                        </tr>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->hasPages()): ?>
                <div class="mt-4 d-flex justify-content-center">
                    <?php echo e($products->links()); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/employee/products.blade.php ENDPATH**/ ?>