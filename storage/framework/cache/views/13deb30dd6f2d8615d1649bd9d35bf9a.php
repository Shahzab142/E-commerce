

<?php $__env->startPush('title'); ?>
    <title><?php echo e($product->name); ?> | <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('style'); ?>
    <style>
        .wishlist-button {
            min-width: 200px;
            height: 44px;
            padding: 0 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            white-space: nowrap;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('meta_description', $product->short_description ?: \Illuminate\Support\Str::limit($product->description, 155)); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $image = $product->images->first();
        $price = $product->sale_price ?? $product->regular_price;
    ?>
    <main class="container py-5">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('shop')); ?>">Shop</a></li>
                <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
            </ol>
        </nav>

        <div class="row ">
            
            <div class="col-lg-6">
                <div class="shop-gallery">
                    <div class="shop-gallery-main">
                        <img src="<?php echo e($image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg')); ?>"
                            alt="<?php echo e($product->name); ?>">
                    </div>
                </div>
            </div>

            
            <div class="col-lg-6">
                <div class="shop-buy-box p-4 rounded-4 border bg-white">
                    <p class="text-muted mb-2"><?php echo e($product->category?->name); ?></p>
                    <h1 class="fw-bold mb-3"><?php echo e($product->name); ?></h1>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->vendor && $product->vendor->isVendor()): ?>
                        <a href="<?php echo e(route('vendor.store', $product->vendor->id)); ?>"
                            class="d-flex align-items-center gap-2 mb-3 text-decoration-none vendor-detail-link">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->vendor->vendorDetail?->logo): ?>
                                <img src="<?php echo e(asset('storage/' . $product->vendor->vendorDetail->logo)); ?>"
                                    alt="<?php echo e($product->vendor->vendorDetail->business_name); ?>" class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            <?php else: ?>
                                <div class="vendor-detail-avatar">
                                    <?php echo e(strtoupper(substr($product->vendor->name, 0, 1))); ?>

                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div>
                                <span
                                    class="text-dark fw-semibold"><?php echo e($product->vendor->vendorDetail->business_name ?? $product->vendor->name); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->vendor->isActive()): ?>
                                    <i class="bi bi-patch-check-fill text-primary ms-1" title="Verified Seller"></i>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        <span class="shop-price-lg">$<?php echo e(number_format((float) $price, 2)); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->sale_price && $product->sale_price < $product->regular_price): ?>
                            <span class="shop-price-old">$<?php echo e(number_format((float) $product->regular_price, 2)); ?></span>
                            <span class="shop-price-off">
                                -<?php echo e(round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100)); ?>%
                            </span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div class="text-warning mb-3">
                        <?php $avgRating = $product->averageRating(); ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= floor($avgRating)): ?>
                                <i class="bi bi-star-fill"></i>
                            <?php elseif($i - 0.5 <= $avgRating): ?>
                                <i class="bi bi-star-half"></i>
                            <?php else: ?>
                                <i class="bi bi-star"></i>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        <span class="text-muted ms-2">(<?php echo e($product->approvedReviews->count()); ?> Reviews)</span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <strong>SKU:</strong>
                            <p class="text-secondary mb-0"><?php echo e($product->sku); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Availability:</strong>
                            <div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->quantity > 0 && $product->stock_status === 'in_stock'): ?>
                                    <span class="badge bg-success">In Stock</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('warning')): ?>
                        <div class="alert alert-warning rounded-3 mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i><?php echo e(session('warning')); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->quantity <= 0 || $product->stock_status !== 'in_stock'): ?>
                        <div class="alert alert-warning rounded-3 mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>This product is out of stock.
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <button type="button" class="btn btn-outline-info btn-lg" onclick="navigator.clipboard.writeText('Name: <?php echo e($product->name); ?>\nPrice: $<?php echo e(number_format((float) $price, 2)); ?>\n<?php echo e($product->short_description); ?>'); alert('Details Copied!');">
                            <i class="bi bi-clipboard me-2"></i>Copy Details
                        </button>
                        <a href="<?php echo e($image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg')); ?>" download class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-download me-2"></i>Download Picture
                        </a>
                        <form action="<?php echo e(route('user.reserve', $product->id)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-bookmark me-2"></i>Reserve
                            </button>
                        </form>
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                        <?php
                            $isInWishlist = isset($wishlistIds[$product->id]);
                        ?>
                        <div class="mt-3">
                            <form action="<?php echo e(route('wishlist.toggle', $product)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit"
                                    class="btn <?php echo e($isInWishlist ? 'btn-danger' : 'btn-outline-danger'); ?> wishlist-button">
                                    <i class="bi bi-heart<?php echo e($isInWishlist ? '-fill' : ''); ?>"></i>
                                    <span><?php echo e($isInWishlist ? 'Remove from Wishlist' : ''); ?></span>
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="mt-3">
                            <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-danger rounded-pill">
                                <i class="bi bi-heart me-1"></i>
                                Add to Wishlist
                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>



                    
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <?php if (isset($component)) { $__componentOriginal96cb3fed74e6f6a56c0fd472f89d069e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal96cb3fed74e6f6a56c0fd472f89d069e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-share','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-share'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal96cb3fed74e6f6a56c0fd472f89d069e)): ?>
<?php $attributes = $__attributesOriginal96cb3fed74e6f6a56c0fd472f89d069e; ?>
<?php unset($__attributesOriginal96cb3fed74e6f6a56c0fd472f89d069e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal96cb3fed74e6f6a56c0fd472f89d069e)): ?>
<?php $component = $__componentOriginal96cb3fed74e6f6a56c0fd472f89d069e; ?>
<?php unset($__componentOriginal96cb3fed74e6f6a56c0fd472f89d069e); ?>
<?php endif; ?>
                        <button class="btn btn-sm btn-outline-secondary" onclick="addToCompare(<?php echo e($product->id); ?>)">
                            <i class="bi bi-arrow-left-right me-1"></i>Compare
                        </button>
                    </div>
                </div>
            </div>


            

            <div class="col-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">About This Item</h3>
                        <p class="text-muted mb-3"><?php echo e($product->short_description); ?></p>
                        <div class="mt-3"><?php echo nl2br(e($product->description)); ?></div>
                    </div>
                </div>
            </div>
        </div>

        
        <h2 class="h4 fw-bold mt-5 mb-4">Customer Reviews</h2>
        <?php $reviews = $product->approvedReviews; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviews->count() > 0): ?>
            <div class="row g-4 mb-5">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->user?->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $review->user->image)); ?>"
                                                alt="<?php echo e($review->user->name); ?>" class="rounded-circle"
                                                style="width: 36px; height: 36px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; font-size: 0.85rem; font-weight: 600;">
                                                <?php echo e(substr($review->user?->name ?? 'U', 0, 1)); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div>
                                            <strong class="small"><?php echo e($review->user?->name ?? 'Anonymous'); ?></strong>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->rating): ?>
                                                <div class="text-warning small">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i <= $review->rating): ?>
                                                            <i class="bi bi-star-fill"></i>
                                                        <?php else: ?>
                                                            <i class="bi bi-star"></i>
                                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                    <small class="text-muted"><?php echo e($review->created_at?->diffForHumans()); ?></small>
                                </div>
                                <p class="text-muted mb-0"><?php echo e($review->comment); ?></p>
                            </div>
                        </div>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-muted mb-5">No reviews yet for this product.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo $__env->make('layouts.reviewes', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <div class="qa-section mt-5">
            <h2 class="h4 fw-bold mb-4"><i class="bi bi-question-circle me-2"></i>Customer Questions & Answers</h2>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success rounded-4 mb-4">
                    <i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <form action="<?php echo e(route('product.question', $product->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="d-flex align-items-start gap-3">
                                <div class="qa-avatar">
                                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="question" rows="2" class="form-control mb-2"
                                        placeholder="Have a question about this product? Ask the seller..." required></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-send me-1"></i>Submit Question
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i><a href="<?php echo e(route('login')); ?>" class="alert-link">Sign in</a> to
                    ask a question about this product.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($questions && $questions->count() > 0): ?>
                <div class="qa-list">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="qa-item">
                            <div class="qa-question">
                                <div class="qa-avatar qa-avatar-q">Q</div>
                                <div class="qa-content">
                                    <p class="fw-semibold mb-1"><?php echo e($qa->question); ?></p>
                                    <small class="text-muted">Asked by <?php echo e($qa->user->name ?? 'Customer'); ?> on
                                        <?php echo e($qa->created_at?->format('M j, Y')); ?></small>
                                </div>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($qa->answer): ?>
                                <div class="qa-answer">
                                    <div class="qa-avatar qa-avatar-a">A</div>
                                    <div class="qa-content">
                                        <p class="mb-1"><?php echo e($qa->answer); ?></p>
                                        <small class="text-muted">Answered by Admin on
                                            <?php echo e($qa->answered_at?->format('M j, Y')); ?></small>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="qa-answer pending">
                                    <p class="text-muted mb-0"><i class="bi bi-hourglass me-1"></i>Awaiting seller
                                        response...</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="bi bi-chat-square-text display-4 text-muted"></i>
                    <p class="text-muted mt-2">No questions yet. Be the first to ask!</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>



        
        <h2 class="h4 fw-bold mt-5 mb-4">Related Products</h2>
        <div class="row g-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="col-md-3">
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $related,'wishlistIds' => $wishlistIds ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($related),'wishlist-ids' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($wishlistIds ?? [])]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </main>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\product-detail.blade.php ENDPATH**/ ?>