<style>
    .emp-sidebar {
        height: calc(100vh - 64px);
        overflow-y: auto;
        padding-bottom: 2rem;
    }
    .emp-sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .emp-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .emp-menu {
        list-style: none;
        padding: 0.75rem 0;
        margin: 0;
    }
    .emp-menu-item {
        margin-bottom: 2px;
    }
    .emp-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 18px;
        color: #475569;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.92rem;
        transition: all 0.2s;
        border-radius: 8px;
        margin: 0 10px;
    }
    .emp-link .icon-label {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .emp-link i.main-icon {
        font-size: 1.15rem;
        color: #64748b;
        transition: color 0.2s;
        width: 20px;
        text-align: center;
    }
    .emp-link:hover, .emp-link.active {
        color: #16a34a;
        background-color: #f0fdf4;
    }
    .emp-link:hover i.main-icon, .emp-link.active i.main-icon {
        color: #16a34a;
    }
    .emp-submenu {
        list-style: none;
        padding: 4px 0 6px 36px;
        margin: 0;
        background-color: #fafafa;
        border-radius: 6px;
        margin: 2px 10px;
    }
    .emp-submenu li a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 7px 12px;
        color: #64748b;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.15s;
        font-weight: 500;
    }
    .emp-submenu li a i {
        font-size: 0.95rem;
        color: #22c55e;
    }
    .emp-submenu li a:hover, .emp-submenu li a.sub-active {
        color: #16a34a;
        font-weight: 600;
    }
    .emp-link .chevron-icon {
        font-size: 0.75rem;
        transition: transform 0.2s;
    }
    .emp-link[aria-expanded="true"] .chevron-icon {
        transform: rotate(180deg);
    }
    .logout-link {
        color: #ef4444 !important;
    }
    .logout-link i {
        color: #ef4444 !important;
    }
    .logout-link:hover {
        background-color: #fef2f2 !important;
    }
</style>

<div id="layoutSidenav_nav">
    <nav class="emp-sidebar">
        <!-- Search bar inside sidebar as in video -->
        <div class="px-3 pt-3 pb-2">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 8px 0 0 8px; padding: 6px 10px;"><i class="fas fa-search text-xs"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="Search for something..." style="border-radius: 0 8px 8px 0; font-size: 0.82rem;" />
            </div>
        </div>

        <ul class="emp-menu">
            <!-- 1. Dashboard -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.dashboard')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.dashboard') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-grid-fill main-icon"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <!-- 2. Orders (Collapsible Submenu) -->
            <?php
                $isOrdersActive = request()->routeIs('employee.orders*');
            ?>
            <li class="emp-menu-item">
                <a class="emp-link <?php echo e($isOrdersActive ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#ordersSubmenu" role="button" aria-expanded="<?php echo e($isOrdersActive ? 'true' : 'false'); ?>">
                    <div class="icon-label">
                        <i class="bi bi-bag-fill main-icon"></i>
                        <span>Orders</span>
                    </div>
                    <i class="bi bi-chevron-down chevron-icon"></i>
                </a>
                <div class="collapse <?php echo e($isOrdersActive ? 'show' : ''); ?>" id="ordersSubmenu">
                    <ul class="emp-submenu">
                        <li><a href="<?php echo e(route('employee.orders', 'all')); ?>" class="<?php echo e(request()->is('employee/orders/all') ? 'sub-active' : ''); ?>"><i class="bi bi-eye"></i> All</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'ordered')); ?>" class="<?php echo e(request()->is('employee/orders/ordered') ? 'sub-active' : ''); ?>"><i class="bi bi-eye"></i> Ordered</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'reviewed')); ?>" class="<?php echo e(request()->is('employee/orders/reviewed') ? 'sub-active' : ''); ?>"><i class="bi bi-eye"></i> Reviewed</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'review-submitted-refund')); ?>" class="<?php echo e(request()->is('employee/orders/review-submitted-refund') ? 'sub-active' : ''); ?>"><i class="bi bi-hand-thumbs-up"></i> Review Submitted Pending Refund</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'review-deleted')); ?>" class="<?php echo e(request()->is('employee/orders/review-deleted') ? 'sub-active' : ''); ?>"><i class="bi bi-x-square"></i> Review Deleted</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'refunded')); ?>" class="<?php echo e(request()->is('employee/orders/refunded') ? 'sub-active' : ''); ?>"><i class="bi bi-arrow-repeat"></i> Refunded</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'on-hold')); ?>" class="<?php echo e(request()->is('employee/orders/on-hold') ? 'sub-active' : ''); ?>"><i class="bi bi-hand-index"></i> On Hold</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'refunded-pending-review')); ?>" class="<?php echo e(request()->is('employee/orders/refunded-pending-review') ? 'sub-active' : ''); ?>"><i class="bi bi-arrow-clockwise"></i> Refunded Pending Review</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'cancelled')); ?>" class="<?php echo e(request()->is('employee/orders/cancelled') ? 'sub-active' : ''); ?>"><i class="bi bi-x-circle"></i> Cancelled</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'commissioned')); ?>" class="<?php echo e(request()->is('employee/orders/commissioned') ? 'sub-active' : ''); ?>"><i class="bi bi-credit-card"></i> Commissioned</a></li>
                        <li><a href="<?php echo e(route('employee.orders', 'completed')); ?>" class="<?php echo e(request()->is('employee/orders/completed') ? 'sub-active' : ''); ?>"><i class="bi bi-check-circle"></i> Completed</a></li>
                    </ul>
                </div>
            </li>

            <!-- 3. Products (Collapsible Categories Submenu) -->
            <?php
                $isProductsActive = request()->routeIs('employee.products*') || request()->routeIs('employee.product.detail');
            ?>
            <li class="emp-menu-item">
                <a class="emp-link <?php echo e($isProductsActive ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#productsSubmenu" role="button" aria-expanded="<?php echo e($isProductsActive ? 'true' : 'false'); ?>">
                    <div class="icon-label">
                        <i class="bi bi-box-seam-fill main-icon"></i>
                        <span>Products</span>
                    </div>
                    <i class="bi bi-chevron-down chevron-icon"></i>
                </a>
                <div class="collapse <?php echo e($isProductsActive ? 'show' : ''); ?>" id="productsSubmenu">
                    <ul class="emp-submenu">
                        <li><a href="<?php echo e(route('employee.products', 'all')); ?>" class="<?php echo e(request()->is('employee/products/all') ? 'sub-active' : ''); ?>"><i class="bi bi-grid"></i> All Products</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'favorites')); ?>" class="<?php echo e(request()->is('employee/products/favorites') ? 'sub-active' : ''); ?>"><i class="bi bi-star-fill text-warning"></i> Favorites</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'general')); ?>" class="<?php echo e(request()->is('employee/products/general') ? 'sub-active' : ''); ?>"><i class="bi bi-tag"></i> General</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'electronics')); ?>" class="<?php echo e(request()->is('employee/products/electronics') ? 'sub-active' : ''); ?>"><i class="bi bi-cpu"></i> Electronics</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'health-beauty')); ?>" class="<?php echo e(request()->is('employee/products/health-beauty') ? 'sub-active' : ''); ?>"><i class="bi bi-heart"></i> Health & Beauty</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'baby-products')); ?>" class="<?php echo e(request()->is('employee/products/baby-products') ? 'sub-active' : ''); ?>"><i class="bi bi-emoji-smile"></i> Baby products</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'gaming-devices')); ?>" class="<?php echo e(request()->is('employee/products/gaming-devices') ? 'sub-active' : ''); ?>"><i class="bi bi-controller"></i> Gaming devices</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'fashion')); ?>" class="<?php echo e(request()->is('employee/products/fashion') ? 'sub-active' : ''); ?>"><i class="bi bi-bag"></i> Fashion (Cloths & shoes)</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'mobile-accessories')); ?>" class="<?php echo e(request()->is('employee/products/mobile-accessories') ? 'sub-active' : ''); ?>"><i class="bi bi-phone"></i> Mobile Accessories</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'expensive-products')); ?>" class="<?php echo e(request()->is('employee/products/expensive-products') ? 'sub-active' : ''); ?>"><i class="bi bi-gem"></i> Expensive products</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'pet-related')); ?>" class="<?php echo e(request()->is('employee/products/pet-related') ? 'sub-active' : ''); ?>"><i class="bi bi-feather"></i> Pet Related</a></li>
                        <li><a href="<?php echo e(route('employee.products', 'home-kitchen')); ?>" class="<?php echo e(request()->is('employee/products/home-kitchen') ? 'sub-active' : ''); ?>"><i class="bi bi-house-door"></i> Home & Kitchen</a></li>
                    </ul>
                </div>
            </li>

            <!-- 4. Reservations (Collapsible) -->
            <?php
                $isResActive = request()->routeIs('employee.reservations*');
            ?>
            <li class="emp-menu-item">
                <a class="emp-link <?php echo e($isResActive ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#resSubmenu" role="button" aria-expanded="<?php echo e($isResActive ? 'true' : 'false'); ?>">
                    <div class="icon-label">
                        <i class="bi bi-calendar2-check-fill main-icon"></i>
                        <span>Reservations</span>
                    </div>
                    <i class="bi bi-chevron-down chevron-icon"></i>
                </a>
                <div class="collapse <?php echo e($isResActive ? 'show' : ''); ?>" id="resSubmenu">
                    <ul class="emp-submenu">
                        <li><a href="<?php echo e(route('employee.reservations.create')); ?>" class="<?php echo e(request()->routeIs('employee.reservations.create') ? 'sub-active' : ''); ?>"><i class="bi bi-plus-circle"></i> Add New</a></li>
                        <li><a href="<?php echo e(route('employee.reservations.index')); ?>" class="<?php echo e(request()->routeIs('employee.reservations.index') ? 'sub-active' : ''); ?>"><i class="bi bi-eye"></i> Show Active</a></li>
                    </ul>
                </div>
            </li>

            <!-- 5. Change Password -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.change-password')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.change-password') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-lock-fill main-icon"></i>
                        <span>Change Password</span>
                    </div>
                </a>
            </li>

            <!-- 6. User Profile -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.profile')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.profile') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-person-circle main-icon"></i>
                        <span>User Profile</span>
                    </div>
                </a>
            </li>

            <!-- 7. Create Excel -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.excel.create')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.excel.*') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-file-earmark-excel-fill main-icon" style="color: #16a34a;"></i>
                        <span>Create Excel</span>
                    </div>
                </a>
            </li>

            <!-- 8. Admins / Management Team -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.admins')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.admins') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-person-badge-fill main-icon"></i>
                        <span>Admins</span>
                    </div>
                </a>
            </li>

            <!-- 9. Support -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.support')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.support') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-envelope-fill main-icon"></i>
                        <span>Support</span>
                    </div>
                </a>
            </li>

            <!-- 10. Check Blacklisted Paypal -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.paypal.blacklisted')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.paypal.blacklisted') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-paypal main-icon" style="color: #003087;"></i>
                        <span>Check Blacklisted Paypal</span>
                    </div>
                </a>
            </li>

            <!-- 11. Delay Refunds -->
            <li class="emp-menu-item">
                <a href="<?php echo e(route('employee.delay-refunds')); ?>" class="emp-link <?php echo e(request()->routeIs('employee.delay-refunds') ? 'active' : ''); ?>">
                    <div class="icon-label">
                        <i class="bi bi-dash-circle-fill main-icon"></i>
                        <span>Delay Refunds</span>
                    </div>
                </a>
            </li>

            <!-- 12. Logout -->
            <li class="emp-menu-item mt-4 pt-2 border-top">
                <form id="emp-logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('emp-logout-form').submit();" class="emp-link logout-link">
                    <div class="icon-label">
                        <i class="bi bi-box-arrow-right main-icon"></i>
                        <span>Logout</span>
                    </div>
                </a>
            </li>
        </ul>
    </nav>
</div>
<div id="layoutSidenav_content">
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\employee\layouts\sidebar.blade.php ENDPATH**/ ?>