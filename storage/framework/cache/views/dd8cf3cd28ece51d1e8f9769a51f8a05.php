<?php $__env->startPush('title'); ?>
    <title>Privacy Policy - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Legal</span>
                <h1 class="display-5 fw-bold mb-3">Privacy Policy</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Your privacy is important to us. This policy explains how we collect, use, and protect your data.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3">1. Information We Collect</h3>
                        <p class="text-muted">We collect personal information such as your name, email, shipping address, and payment details when you create an account or place an order.</p>

                        <h3 class="fw-bold mt-4 mb-3">2. How We Use Your Data</h3>
                        <p class="text-muted">Your data is used to process orders, improve customer service, personalize your shopping experience, and send important account updates.</p>

                        <h3 class="fw-bold mt-4 mb-3">3. Data Security</h3>
                        <p class="text-muted">We implement industry-standard security measures to protect your personal information. Sensitive payment data is encrypted and processed through secure gateways.</p>

                        <h3 class="fw-bold mt-4 mb-3">4. Cookies & Tracking</h3>
                        <p class="text-muted">We use cookies to improve site performance, remember preferences, and analyze traffic. You can manage cookies through your browser settings.</p>

                        <h3 class="fw-bold mt-4 mb-3">5. Your Rights</h3>
                        <p class="text-muted">You have the right to access, update, or delete your personal data. Contact our support team for any privacy-related requests.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views/privacy.blade.php ENDPATH**/ ?>