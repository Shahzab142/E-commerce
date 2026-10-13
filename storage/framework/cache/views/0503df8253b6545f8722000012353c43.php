<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="author" content="" />
    <?php echo $__env->yieldPushContent('title'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_file(public_path('assets/images/logo.png'))): ?>
        <link rel="icon" type="image/png" href="<?php echo e(asset('assets/images/logo.png')); ?>">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <link href="<?php echo e(url('dashboard/css/styles.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(url('assets/css/dashboard.css')); ?>" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body class="sb-nav-fixed bg-light">
    <nav class="sb-topnav navbar navbar-expand navbar-light shadow-sm" style="background-color: #ffffff !important; border-bottom: 1px solid #e0e0e0 !important;">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 fw-bold text-dark" style="width: 225px;" href="<?php echo e(url('/admin')); ?>">
            <!-- KHYBAR PRO brand is handled in sidebar -->
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-dark" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control bg-light border-0" type="text" placeholder="Search for something..." aria-label="Search for something..."
                    aria-describedby="btnNavbarSearch" style="border-radius: 20px 0 0 20px;" />
                <button class="btn btn-light border-0" id="btnNavbarSearch" type="button" style="border-radius: 0 20px 20px 0;"><i
                        class="fas fa-search text-muted"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 d-flex align-items-center">
            <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-success btn-sm me-3" target="_blank">
                <i class="bi bi-globe me-1"></i> Visit Store
            </a>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <?php
                        $adminImage = auth()->user()->adminDetail?->image
                            
                            ?? auth()->user()->image;
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($adminImage): ?>
                        <img src="<?php echo e(asset('storage/' . $adminImage)); ?>" alt="<?php echo e(auth()->user()->name); ?>"
                             class="rounded-circle border" style="width: 32px; height: 32px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="fas fa-user fa-sm"></i>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="<?php echo e(url('admin/profile')); ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="<?php echo e(url('/')); ?>" target="_blank">Go To Website</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <form id="logout-form" action="<?php echo e(url('logout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button class="dropdown-item btn btn-danger" type="submit" form="logout-form">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>