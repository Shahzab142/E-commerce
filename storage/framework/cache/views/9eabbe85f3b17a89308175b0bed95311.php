<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <?php echo $__env->make('partials.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <style>
            .khybar-logo-auth {
                text-align: center;
                margin-bottom: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
            }
            .khybar-logo-auth .arrow {
                color: #dc3545;
                font-size: 2rem;
                font-weight: 900;
            }
            .khybar-logo-auth .text {
                color: #2c3e50;
                font-size: 1.8rem;
                font-weight: 800;
                letter-spacing: -1px;
                font-style: italic;
            }
        </style>
    </head>
    <body class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7">
                    <div class="khybar-logo-auth">
                        <span class="arrow"><i class="bi bi-arrow-up-right"></i></span>
                        <span class="text">KHYBAR PRO</span>
                    </div>
                    <div class="card border-0 shadow-lg" style="border-radius: 1.25rem; overflow: hidden; background: #fff;">
                        <div class="card-body p-0">
                            <?php echo e($slot); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\components\layouts\auth\simple.blade.php ENDPATH**/ ?>