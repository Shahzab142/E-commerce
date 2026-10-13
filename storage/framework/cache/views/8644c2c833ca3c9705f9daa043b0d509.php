<nav class="sb-topnav navbar navbar-expand navbar-light bg-white" style="border-bottom: 1px solid #e0e0e0; box-shadow: none;">
    <a class="navbar-brand ps-3" href="<?php echo e(route('home')); ?>">
        <?php echo $__env->make('partials.site-logo', ['markClass' => 'brand-mark'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo e(config('app.name', 'Shop Hub')); ?>

    </a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    <div class="ms-auto d-flex align-items-center">
        <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-success btn-sm me-2" target="_blank">
            <i class="bi bi-globe me-1"></i> Visit Store
        </a>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php
                    $userImage = auth()->user()->image
                        
                        ?? auth()->user()->adminDetail?->image;
                ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($userImage): ?>
                    <img src="<?php echo e(asset('storage/' . $userImage)); ?>" alt="<?php echo e(auth()->user()->name); ?>"
                         class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                <?php else: ?>
                    <i class="fas fa-user fa-fw"></i>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="<?php echo e(route('user.settings')); ?>">
                    <i class="fas fa-user me-2 text-muted"></i>Profile
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </li>
    </div>
</nav>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/user/layouts/header.blade.php ENDPATH**/ ?>