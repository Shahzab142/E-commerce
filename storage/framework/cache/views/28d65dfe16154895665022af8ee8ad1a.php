<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        New Sale Notification
    <?php $__env->endSlot(); ?>

    <h2>New Order #<?php echo e($order->order_number); ?></h2>
    <p>Hello <strong><?php echo e($vendor->name); ?></strong>, a customer purchased products from your store. Here are the details.</p>

    <div class="card">
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order #</span>
            <span class="info-value">#<?php echo e($order->order_number); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer</span>
            <span class="info-value"><?php echo e($customerName); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Date</span>
            <span class="info-value"><?php echo e($order->placed_at?->format('M d, Y') ?? $order->created_at->format('M d, Y')); ?></span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Your Items</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="info-row">
                <span class="info-label"><?php echo e($item['product_name']); ?> <span style="color: #94a3b8; font-size: 13px;">x<?php echo e($item['quantity']); ?></span></span>
                <span class="info-value">$<?php echo e(number_format($item['unit_price'], 2)); ?></span>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="color: #94a3b8; margin: 0;">No items found.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="card">
        <div class="section-title">Shipping Information</div>
        <p style="margin: 0; color: #1e293b; line-height: 1.6;">
            <strong>Ship to:</strong><br>
            <?php echo e($order->shipping_address); ?><br>
            <?php echo e($order->shipping_name); ?><br>
            <?php echo e($order->shipping_phone); ?>

        </p>
    </div>

    <p>If you have any questions about this order, contact the customer or our support team.</p>

    Thanks for your business!<br>
    <strong><?php echo e(config('app.name', 'Shop Hub')); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\orders\vendor.blade.php ENDPATH**/ ?>