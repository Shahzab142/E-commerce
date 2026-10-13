

<?php $__env->startPush('title'); ?>
    <title>Search - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('meta_description', $query !== ''
    ? 'Search results for "' . $query . '" on ' . config('app.name', 'Shop Hub') . '.'
    : 'Browse products, filters and deals on ' . config('app.name', 'Shop Hub') . '.'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">

        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('shop')); ?>">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
            <h2 class="h4 fw-bold mb-1">
                <i class="bi bi-search me-2 text-primary"></i>Search Results
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($query !== ''): ?>
                    <span class="text-muted small fw-normal">for "<?php echo e($query); ?>"</span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </h2>
            <p class="text-muted small mb-0">
                <?php echo e($products->total()); ?> product<?php echo e($products->total() === 1 ? '' : 's'); ?> found
            </p>
        </div>

        <div class="col-lg-3">
            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5>
                </div>
                <div class="card-body p-2">
                    <ul class="list-unstyled">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <?php
                                $isActive = request('category') === $category->slug;
                            ?>
                            <li>
                                <a href="<?php echo e(url('category/' . $category->slug)); ?>"
                                    class="d-block py-2 px-3 text-dark text-decoration-none small <?php echo e($isActive ? 'fw-semibold text-primary' : ''); ?>">
                                    <?php echo e($category->name); ?>

                                    <span class="text-muted small float-end">(<?php echo e($category->products_count); ?>)</span>
                                </a>
                            </li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <li class="px-3 py-2 text-muted small">No categories found.</li>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-currency-dollar me-2"></i>Price Range</h5>
                </div>
                <div class="card-body">
                    <form id="price-filter-form" class="d-grid gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="min" class="form-control form-control-sm"
                                   placeholder="Min $" value="<?php echo e(request('min', '')); ?>" min="0">
                            <input type="number" name="max" class="form-control form-control-sm"
                                   placeholder="Max $" value="<?php echo e(request('max', '')); ?>" min="0">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('min') || request('max') || request('rating') || request('availability')): ?>
                            <a href="<?php echo e(route('search')); ?>?q=<?php echo e(request('q', '')); ?>"
                               class="btn btn-sm btn-outline-secondary">Reset</a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-star me-2"></i>Rating</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-grid gap-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [5 => '5 Stars', 4 => '4 Stars & up', 3 => '3 Stars & up', 2 => '2 Stars & up', 1 => '1 Star & up']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <a href="<?php echo e(route('search', array_filter(['q' => $query, 'rating' => $value]))); ?>"
                               class="btn btn-sm <?php echo e(request('rating') == $value ? 'btn-primary' : 'btn-outline-secondary'); ?> text-start">
                                <i class="bi bi-star-fill text-warning me-1"></i><?php echo e($label); ?>

                            </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Availability</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('search', array_filter(['q' => $query, 'availability' => 'in_stock']))); ?>"
                           class="btn btn-sm <?php echo e(request('availability') === 'in_stock' ? 'btn-primary' : 'btn-outline-secondary'); ?> text-start">
                            In stock
                        </a>
                        <a href="<?php echo e(route('search', array_filter(['q' => $query, 'availability' => 'on_sale']))); ?>"
                           class="btn btn-sm <?php echo e(request('availability') === 'on_sale' ? 'btn-primary' : 'btn-outline-secondary'); ?> text-start">
                            On sale
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="h5 fw-bold mb-0">Results</h2>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <form method="GET" action="<?php echo e(route('search')); ?>" class="d-flex">
                        <input type="text" name="q" class="form-control form-control-sm"
                               placeholder="Search products..." value="<?php echo e($query); ?>" required>
                    </form>
                    <select name="sort" class="form-select form-select-sm w-auto" onchange="updateSort(this.value)">
                        <option value="newest" <?php echo e($sort === 'newest' ? 'selected' : ''); ?>>Newest</option>
                        <option value="price_low" <?php echo e($sort === 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo e($sort === 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                        <option value="rating" <?php echo e($sort === 'rating' ? 'selected' : ''); ?>>Top Rated</option>
                    </select>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="alert alert-success"><?php echo e(session('success')); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <div class="col">
                        <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product,'wishlistIds' => $wishlistIds ?? []]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'wishlist-ids' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($wishlistIds ?? [])]); ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">No products found for "<?php echo e($query ?: 'the selected filters'); ?>".</p>
                        <a href="<?php echo e(route('shop')); ?>" class="btn btn-sm btn-primary mt-2">Browse all products</a>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="mt-4">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    </div>
</div>

<script>
    function updateSort(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }

    document.getElementById('price-filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        const minPrice = this.min.value;
        const maxPrice = this.max.value;
        if (minPrice) url.searchParams.set('min', minPrice);
        else url.searchParams.delete('min');
        if (maxPrice) url.searchParams.set('max', maxPrice);
        else url.searchParams.delete('max');
        window.location.href = url.toString();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/search.blade.php ENDPATH**/ ?>