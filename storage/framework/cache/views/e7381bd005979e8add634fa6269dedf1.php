

<?php $__env->startSection('title', 'My Wishlist - User'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* ================================
           Wishlist Page
        ================================= */

        .wishlist-page {
            background: #f7f8fc;
            min-height: 100%;
        }

        .wishlist-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            color: #fff;
            box-shadow: 0 10px 30px rgba(79, 70, 229, 0.14);
        }

        .wishlist-header h1 {
            color: #fff;
        }

        .wishlist-header p {
            color: rgba(255, 255, 255, 0.8);
        }

        .wishlist-count {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-top: 0.35rem;
            font-size: 0.85rem;
        }

        /* ================================
           Wishlist Grid
        ================================= */

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        /* ================================
           Product Card
        ================================= */

        .wishlist-item {
            min-width: 0;
        }

        .product-card {
            height: 100%;
            border: 1px solid #e8e9f0;
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: rgba(79, 70, 229, 0.15);
            box-shadow: 0 16px 35px rgba(15, 23, 42, 0.10);
        }

        /* ================================
           Product Image
        ================================= */

        .card-img-wrapper {
            position: relative;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            background: #f8f9fa;
        }

        .card-img-wrapper img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .product-card:hover .card-img-wrapper img {
            transform: scale(1.04);
        }

        /* ================================
           Discount Badge
        ================================= */

        .badge-discount {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            z-index: 5;
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            background: #dc3545;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.2);
        }

        /* ================================
           Wishlist Button
        ================================= */

        .wishlist-btn {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            z-index: 10;

            width: 38px;
            height: 38px;
            padding: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border: 1px solid #e5e7eb;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.96);
            color: #dc3545;

            box-shadow: 0 5px 15px rgba(15, 23, 42, 0.08);

            transition:
                transform 0.2s ease,
                background 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
        }

        .wishlist-btn:hover {
            transform: scale(1.08);
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .wishlist-btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.18);
        }

        /* ================================
           Product Content
        ================================= */

        .product-card .card-body {
            display: flex;
            flex-direction: column;
            padding: 1.1rem;
        }

        .card-title {
            margin: 0;
            min-height: 2.8em;

            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;

            color: #212529;
            font-size: 0.95rem;
            font-weight: 600;
            line-height: 1.4;
        }

        .card-price {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.4rem;

            margin-top: 0.65rem;

            color: #dc3545;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .original {
            color: #8a8f98;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: line-through;
        }

        /* ================================
           Action Buttons
        ================================= */

        .product-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .product-actions > a,
        .product-actions > form {
            flex: 1 1 0;
            min-width: 0;
        }

        .product-actions .btn {
            width: 100%;
            min-height: 38px;
            font-size: 0.78rem;
            font-weight: 600;
        }

        .btn-details {
            border-radius: 0.55rem;
        }

        /* ================================
           Empty Wishlist
        ================================= */

        .empty-wishlist {
            padding: 4.5rem 2rem;
            border: 1px solid #e8e9f0;
            border-radius: 1rem;
            background: #fff;
            text-align: center;
            box-shadow: 0 5px 20px rgba(15, 23, 42, 0.04);
        }

        .empty-wishlist-icon {
            width: 82px;
            height: 82px;
            margin: 0 auto 1.25rem;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;
            background: rgba(220, 53, 69, 0.08);
            color: #dc3545;
            font-size: 2.4rem;
        }

        .empty-wishlist h2 {
            color: #212529;
        }

        /* ================================
           Responsive
        ================================= */

        @media (max-width: 767.98px) {
            .wishlist-header {
                padding: 1.25rem;
            }

            .wishlist-header .btn {
                width: 100%;
                margin-top: 1rem;
            }

            .wishlist-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
            }

            .product-card .card-body {
                padding: 0.9rem;
            }

            .product-actions {
                flex-direction: column;
            }

            .product-actions > a,
            .product-actions > form {
                width: 100%;
            }
        }

        @media (max-width: 479.98px) {
            .wishlist-grid {
                grid-template-columns: 1fr;
            }

            .wishlist-header h1 {
                font-size: 1.35rem;
            }

            .empty-wishlist {
                padding: 3rem 1.25rem;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <div class="wishlist-page">
        <div class="container-fluid px-3 px-md-4 py-4">

            
            <div class="wishlist-header mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                    <div>
                        <h1 class="h3 fw-bold mb-0">
                            <i class="bi bi-heart-fill me-2"></i>
                            My Wishlist
                        </h1>

                        <div class="wishlist-count">
                            <i class="bi bi-bookmark-heart"></i>
                            <span>
                                <?php echo e($items->count()); ?>

                                <?php echo e($items->count() === 1 ? 'item' : 'items'); ?>

                                in your wishlist
                            </span>
                        </div>
                    </div>

                    <a href="<?php echo e(url('/')); ?>"
                       class="btn btn-light btn-sm rounded-pill px-3 fw-semibold">
                        <i class="bi bi-shop me-1"></i>
                        Continue Shopping
                    </a>

                </div>
            </div>


            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm"
                     role="alert">

                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?php echo e(session('success')); ?>


                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($items->isEmpty()): ?>

                <div class="empty-wishlist">

                    <div class="empty-wishlist-icon">
                        <i class="bi bi-heart"></i>
                    </div>

                    <h2 class="h4 fw-bold mb-2">
                        Your wishlist is empty
                    </h2>

                    <p class="text-muted mb-4">
                        You haven't added any products to your wishlist yet.
                        Start exploring and save products you love.
                    </p>

                    <a href="<?php echo e(url('/')); ?>"
                       class="btn btn-primary rounded-pill px-4 fw-semibold">

                        <i class="bi bi-shop me-1"></i>
                        Browse Products

                    </a>

                </div>

            <?php else: ?>

                
                <div class="wishlist-grid">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                        <?php
                            $product = $item->product;

                            $image = $product->images->first();

                            $discount = $product->discountPercent();

                            $currentPrice = $product->currentPrice();

                            $regularPrice = (float) $product->regular_price;
                        ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product): ?>

                            <div class="wishlist-item">

                                <div class="product-card">

                                    
                                    <div class="card-img-wrapper">

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount > 0): ?>
                                            <span class="badge-discount">
                                                <?php echo e($discount); ?>% OFF
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


                                        <img
                                            src="<?php echo e($image
                                                ? asset('storage/' . $image->image)
                                                : asset('assets/images/products/placeholder.jpg')); ?>"
                                            alt="<?php echo e($product->name); ?>"
                                            loading="lazy"
                                        >


                                        
                                        <form action="<?php echo e(route('wishlist.toggle', $product)); ?>"
                                              method="POST">

                                            <?php echo csrf_field(); ?>

                                            <button type="submit"
                                                    class="wishlist-btn"
                                                    title="Remove from wishlist"
                                                    aria-label="Remove <?php echo e($product->name); ?> from wishlist">

                                                <i class="bi bi-heart-fill"></i>

                                            </button>

                                        </form>

                                    </div>


                                    
                                    <div class="card-body">

                                        <h6 class="card-title"
                                            title="<?php echo e($product->name); ?>">
                                            <?php echo e($product->name); ?>

                                        </h6>


                                        
                                        <div class="card-price">

                                            <span>
                                                $<?php echo e(number_format($currentPrice, 2)); ?>

                                            </span>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount > 0): ?>
                                                <span class="original">
                                                    $<?php echo e(number_format($regularPrice, 2)); ?>

                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </div>


                                        
                                        <div class="product-actions">

                                            <a href="<?php echo e(route('product.detail', $product)); ?>"
                                               class="btn btn-outline-primary btn-sm rounded-pill btn-details">

                                                <i class="bi bi-eye me-1"></i> View Details
                                              

                                            </a>


                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->stock_status === 'in_stock' && $product->quantity > 0): ?>

                                                <form action="<?php echo e(route('cart.add', $product)); ?>"
                                                      method="POST">

                                                    <?php echo csrf_field(); ?>

                                                    <button type="submit"
                                                            class="btn btn-primary btn-sm rounded-pill btn-details">

                                                        <i class="bi bi-cart-plus me-1"></i> Add to Cart
                                                        

                                                    </button>

                                                </form>

                                            <?php else: ?>

                                                <button type="button"
                                                        class="btn btn-secondary btn-sm rounded-pill btn-details"
                                                        disabled>

                                                    <i class="bi bi-x-circle me-1"></i>
                                                    Out of Stock

                                                </button>

                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </div>

            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\wishlist.blade.php ENDPATH**/ ?>