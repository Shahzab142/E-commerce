<?php $__env->startPush('title'); ?>
    <title>Register - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="h-100 position-relative" style="background: linear-gradient(135deg, #1c2541 0%, #2f5af0 100%);">
                                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: url('<?php echo e(asset('assets/images/register.jpg')); ?>') center/cover; opacity: 0.15;"></div>
                                <div class="position-relative z-1 h-100 d-flex flex-column justify-content-center align-items-center text-center p-5 text-white">
                                    <div class="mb-4">
                                        <i class="bi bi-person-plus display-1 opacity-75"></i>
                                    </div>
                                    <h2 class="fw-bold mb-3">Create Account</h2>
                                    <p class="lead opacity-75 mb-4">Join our community of shoppers and discover amazing deals every day.</p>
                                    <div class="d-flex gap-3">
                                        <div class="text-center">
                                            <i class="bi bi-tags display-6 mb-2"></i>
                                            <p class="small mb-0 opacity-75">Best Prices</p>
                                        </div>
                                        <div class="text-center">
                                            <i class="bi bi-truck display-6 mb-2"></i>
                                            <p class="small mb-0 opacity-75">Fast Delivery</p>
                                        </div>
                                        <div class="text-center">
                                            <i class="bi bi-headset display-6 mb-2"></i>
                                            <p class="small mb-0 opacity-75">24/7 Support</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-lg-6">
                            <div class="card-body p-5 p-lg-6 d-flex flex-column justify-content-center h-100">
                                <div class="text-center mb-4">
                                    <h1 class="fw-bold text-dark mb-2">Get Started</h1>
                                    <p class="text-muted">Create your account in just a few steps.</p>
                                </div>

                                <form>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Mobile Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-telephone"></i>
                                            </span>
                                            <input type="tel" class="form-control form-control-lg border-start-0 ps-0" placeholder="+91">
                                        </div>
                                        <div class="form-text">We'll send you a one-time verification code to verify your number.</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill mb-3">
                                        Continue
                                    </button>

                                    <div class="text-center">
                                        <span class="text-muted">Already have an account?</span>
                                        <a href="<?php echo e(url('login')); ?>" class="text-decoration-none fw-semibold ms-1">Sign in</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\register.blade.php ENDPATH**/ ?>