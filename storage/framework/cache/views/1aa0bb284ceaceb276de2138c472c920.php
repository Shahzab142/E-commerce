<?php $__env->startPush('title'); ?>
    <title>Product Details - <?php echo e($product->name); ?></title>
    <style>
        .detail-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
            margin-bottom: 24px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.95rem;
        }
        .detail-value {
            font-weight: 500;
            color: #0f172a;
            font-size: 0.95rem;
        }
        .product-hero-img {
            max-width: 320px;
            width: 100%;
            border-radius: 8px;
            object-fit: contain;
            border: 1px solid #e2e8f0;
            padding: 8px;
            background: #ffffff;
        }
        .btn-copy-kw {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            color: #334155;
            padding: 4px 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-copy-kw:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .badge-refund {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.82rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main>
    <div class="container px-2" style="max-width: 960px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <small class="text-muted text-uppercase fw-bold">OVERVIEW</small>
                <h2 class="fw-bold text-dark mb-0">Product Details</h2>
            </div>
            <a href="<?php echo e(route('employee.products', 'all')); ?>" class="btn btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-arrow-left me-1"></i> Back to Products
            </a>
        </div>

        <div class="row g-4">
            <!-- Left: Pictures Card -->
            <div class="col-lg-5">
                <div class="detail-card text-center">
                    <h5 class="fw-bold mb-3 text-start">Picture</h5>
                    <?php
                        $img = $product->images->first()?->image;
                        $imgUrl = $img ? asset('storage/' . $img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400';
                    ?>
                    <img src="<?php echo e($imgUrl); ?>" alt="<?php echo e($product->name); ?>" class="product-hero-img mb-3">
                    <h6 class="fw-bold text-dark"><?php echo e($product->name); ?></h6>
                    <div class="text-warning mb-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <span class="text-muted ms-1 small">(5.0)</span>
                    </div>
                    <div class="fs-4 fw-bold text-primary mb-3">
                        $<?php echo e(number_format($product->sale_price ?? $product->regular_price ?? 0, 2)); ?>

                    </div>

                    <div class="d-grid gap-2">
                        <form action="<?php echo e(route('employee.reservations.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                <i class="bi bi-calendar2-check me-1"></i> Reserve This Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right: Details Card (Matching Video) -->
            <div class="col-lg-7">
                <div class="detail-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Details</h5>
                        <button type="button" class="btn-copy-kw" onclick="navigator.clipboard.writeText('<?php echo e(addslashes($product->name)); ?>'); alert('Keyword copied!');" title="Copy Keyword">
                            <i class="bi bi-copy me-1"></i> Copy Keyword
                        </button>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Keyword :</span>
                        <span class="detail-value text-primary fw-semibold"><?php echo e($product->name); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Sold By :</span>
                        <span class="detail-value"><?php echo e($product->sku ?? 'HUANSHANG'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Brand Name :</span>
                        <span class="detail-value">Generic / Prime</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Product ID :</span>
                        <span class="detail-value fw-bold">#<?php echo e($product->id); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Market :</span>
                        <span class="detail-value"><span class="badge bg-light text-dark border">US / FR</span></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Category :</span>
                        <span class="detail-value"><?php echo e($product->category->name ?? 'Electronics'); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Commission :</span>
                        <span class="detail-value text-success fw-bold">$<?php echo e(number_format((float)($product->regular_price * 0.1), 2)); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Product Type :</span>
                        <span class="detail-value">Text Review</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Overall Sale Limit :</span>
                        <span class="detail-value fw-bold">3</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Daily Sale Limit :</span>
                        <span class="detail-value fw-bold">1</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Product Price :</span>
                        <span class="detail-value">$<?php echo e(number_format($product->sale_price ?? $product->regular_price ?? 0, 2)); ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Less Refund :</span>
                        <span class="detail-value">0</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Available Refund Type :</span>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge-refund"><i class="bi bi-check"></i> Paypal Fee Covered</span>
                            <span class="badge-refund"><i class="bi bi-check"></i> Tax Cover</span>
                            <span class="badge-refund"><i class="bi bi-check"></i> Shipping Charges Cover</span>
                        </div>
                    </div>
                </div>

                <!-- Instructions Card -->
                <div class="detail-card bg-light border">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-info-circle text-primary me-2"></i>Instructions:</h6>
                    <ol class="small text-muted mb-0 ps-3">
                        <li class="mb-1">Review need to be submitted after 7 days of shipment received.</li>
                        <li class="mb-1">Must use keyword for product search.</li>
                        <li>Buyer should be honest, scammer buyer is responsibility of PM.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('employee.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\product-detail.blade.php ENDPATH**/ ?>