<style>
    .khybar-sidebar {
        background-color: #ffffff;
        border-right: 1px solid #e0e0e0;
        height: calc(100vh - 56px);
        overflow-y: auto;
    }

    /* Scrollbar Styling for Sidebar */
    .khybar-sidebar::-webkit-scrollbar {
        width: 6px;
    }
    .khybar-sidebar::-webkit-scrollbar-track {
        background: #ffffff;
    }
    .khybar-sidebar::-webkit-scrollbar-thumb {
        background: #e0e0e0;
        border-radius: 10px;
    }
    .khybar-sidebar::-webkit-scrollbar-thumb:hover {
        background: #28a745;
    }
    .khybar-brand {
        padding: 20px 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-bottom: 1px solid #e0e0e0;
    }
    .khybar-brand .arrow {
        color: #28a745;
        font-size: 1.5rem;
        font-weight: 900;
    }
    .khybar-brand .text {
        color: #333333;
        font-size: 1.2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .sidebar-menu {
        padding: 10px 0;
        list-style: none;
        margin: 0;
    }
    .sidebar-menu li a {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: #555555;
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.2s;
    }
    .sidebar-menu li a i {
        margin-right: 15px;
        font-size: 1.2rem;
        color: #28a745; /* Green icons like the video */
    }
    .sidebar-menu li.active a {
        color: #28a745;
        border-left: 4px solid #28a745;
        background-color: #f8f9fa;
    }
    .sidebar-menu li.active a i {
        color: #28a745;
    }
    .sidebar-menu li a:hover {
        background-color: #f8f9fa;
        color: #28a745;
    }
    .sidebar-menu li.logout a {
        color: #dc3545;
    }
    .sidebar-menu li.logout a i {
        color: #dc3545;
    }
</style>

<div id="layoutSidenav">
    <div id="layoutSidenav_nav" style="background-color: #ffffff !important;">
        <nav class="sb-sidenav khybar-sidebar" id="sidenavAccordion" style="background-color: #ffffff !important;">

        
        <div class="khybar-brand">
            <span class="arrow"><i class="bi bi-arrow-up-right"></i></span>
            <span class="text">KHYBAR PRO</span>
        </div>

        <ul class="sidebar-menu">
            <li class="<?php echo e(request()->is('admin') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('/admin')); ?>">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/employees*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.employees.index')); ?>">
                    <i class="bi bi-people-fill"></i> Employees
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/orders*') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('admin/orders')); ?>">
                    <i class="bi bi-basket"></i> Orders
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/*product*') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('admin/view-product')); ?>">
                    <i class="bi bi-briefcase"></i> Products
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/reservations*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.reservations.index')); ?>">
                    <i class="bi bi-calendar-check"></i> Reservations
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/change-password*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.change-password')); ?>">
                    <i class="bi bi-lock"></i> Change Password
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/profile*') ? 'active' : ''); ?>">
                <a href="<?php echo e(url('admin/profile')); ?>">
                    <i class="bi bi-person-circle"></i> User Profile
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/excel*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.excel.create')); ?>">
                    <i class="bi bi-file-earmark-excel"></i> Create Excel
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/admins*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.admins')); ?>">
                    <i class="bi bi-person-badge"></i> Admins
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/support*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.support')); ?>">
                    <i class="bi bi-envelope"></i> Support
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/paypal*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.paypal.blacklisted')); ?>">
                    <i class="bi bi-paypal"></i> Check Blacklisted Paypal
                </a>
            </li>
            <li class="<?php echo e(request()->is('admin/delay-refunds*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.delay-refunds')); ?>">
                    <i class="bi bi-dash-circle"></i> Delay Refunds
                </a>
            </li>
            
            <li style="margin-top: 40px;" class="logout">
                <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
        
    </nav>
</div>
<div id="layoutSidenav_content">
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\admin\layouts\sidebar.blade.php ENDPATH**/ ?>