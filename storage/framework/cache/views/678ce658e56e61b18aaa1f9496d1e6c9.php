

<style>
    .daraz-top-bar {
        background-color: #f85606;
        padding: 4px 0;
    }
    .daraz-top-bar a {
        color: white;
        text-decoration: none;
        font-size: 12px;
        margin-left: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .daraz-top-bar a:hover {
        color: #ffe0d1;
    }
    .top-auth-btn {
        background-color: white;
        color: #f85606 !important;
        padding: 3px 14px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 13px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: all 0.2s ease-in-out;
        margin-left: 25px !important;
    }
    .top-auth-btn:hover {
        background-color: #fff4ed;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .daraz-header {
        background-color: #f85606;
        padding: 10px 0 15px 0;
    }
    .daraz-logo-text {
        color: white;
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .daraz-search-form {
        display: flex;
        width: 100%;
        max-width: 650px;
        background: white;
        border-radius: 2px;
        overflow: hidden;
    }
    .daraz-search-input {
        border: none;
        padding: 10px 15px;
        width: 100%;
        outline: none;
    }
    .daraz-search-btn {
        background: #ffe0d1;
        border: none;
        padding: 0 20px;
        color: #f85606;
        cursor: pointer;
    }
    .daraz-search-btn:hover {
        background: #ffccb3;
    }
    .daraz-cart-icon {
        color: white;
        font-size: 24px;
        text-decoration: none;
        position: relative;
    }
    .daraz-cart-badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: white;
        color: #f85606;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: bold;
    }
</style>

<!-- Announcement Bar -->
<div class="daraz-top-bar d-none d-md-block">
    <div class="container d-flex justify-content-end">
        <a href="#">KHYBER PRO EMPLOYEE PORTAL</a>
        <a href="#">HELP & SUPPORT</a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="top-auth-btn"><i class="bi bi-box-arrow-in-right me-1"></i> LOGIN</a>
            <a href="<?php echo e(route('register')); ?>" class="top-auth-btn"><i class="bi bi-person-plus-fill me-1"></i> SIGN UP</a>
        <?php else: ?>
            <a href="<?php echo e(route(auth()->user()->dashboardRoute())); ?>" class="top-auth-btn"><i class="bi bi-speedometer2 me-1"></i> DASHBOARD</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="top-auth-btn"><i class="bi bi-box-arrow-right me-1"></i> LOGOUT</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none"><?php echo csrf_field(); ?></form>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>


<nav class="daraz-header shop-header">
    <div class="container">
        <div class="shop-header-inner d-flex align-items-center justify-content-between">
            
            <a href="<?php echo e(route('home')); ?>" class="text-decoration-none d-flex align-items-center me-4">
                <?php echo $__env->make('partials.site-logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </a>

            
            <div class="flex-grow-1 mx-4 d-none d-lg-block position-relative">
                <form class="daraz-search-form" action="<?php echo e(route('search')); ?>" method="GET" id="searchForm">
                    <input type="search" class="daraz-search-input" name="q" placeholder="Search Product"
                        aria-label="Search" value="<?php echo e(request('q')); ?>" id="searchInput" autocomplete="off" required>
                    <button type="submit" class="daraz-search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                
                <div class="search-autocomplete-dropdown" id="searchDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; z-index: 1000; border-radius: 0 0 4px 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2px;">
                    <div class="search-autocomplete-products p-2" id="searchProducts"></div>
                    <div class="search-autocomplete-categories p-2" id="searchCategories"></div>
                </div>
            </div>
            
            
            <div class="d-flex align-items-center gap-4">
                
                <button class="btn btn-link text-white d-lg-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch">
                    <i class="bi bi-search fs-4"></i>
                </button>


            </div>
        </div>

        
        <div class="collapse d-lg-none mt-3" id="mobileSearch">
            <form class="daraz-search-form w-100" action="<?php echo e(route('search')); ?>" method="GET">
                <input type="search" class="daraz-search-input" name="q" placeholder="Search Product"
                    value="<?php echo e(request('q')); ?>" required>
                <button type="submit" class="daraz-search-btn">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>


<nav class="shop-cat-rail">
    <div class="container">
        <ul class="nav">
            <?php
                $categories = \App\Models\AdminCategory::query()
                    ->where('status', 'published')
                    ->withCount('products')
                    ->orderBy('name')
                    ->get();
            ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('shop')); ?>">
                    <i class="bi bi-grid me-1"></i>All Products
                </a>
            </li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <li class="nav-item mega-menu-item">
                    <a class="nav-link" href="<?php echo e(url('category/' . $category->slug)); ?>">
                        <?php echo e($category->name); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->products_count > 0): ?>
                            <span class="badge bg-light text-dark ms-1"><?php echo e($category->products_count); ?></span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category->children && $category->children->count() > 0): ?>
                        <div class="mega-menu-dropdown">
                            <div class="row g-4 p-4">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $category->children->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="col-4">
                                        <a href="<?php echo e(url('category/' . $child->slug)); ?>" class="mega-menu-link">
                                            <?php echo e($child->name); ?>

                                        </a>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('shop')); ?>">All Products</a>
                </li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->count() > 10): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">More</a>
                    <ul class="dropdown-menu">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories->skip(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo e(url('category/' . $category->slug)); ?>"><?php echo e($category->name); ?></a></li>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
</nav>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\layouts\header.blade.php ENDPATH**/ ?>