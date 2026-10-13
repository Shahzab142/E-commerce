<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Order Confirmation
    <?php $__env->endSlot(); ?>

    <h2>Order #<?php echo e($order->order_number); ?> Confirmed</h2>
    <p>Thank you for your purchase! We’ve received your order and it is being processed.</p>

    <div class="card">
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order Number</span>
            <span class="info-value">#<?php echo e($order->order_number); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Date</span>
            <span class="info-value"><?php echo e($order->placed_at?->format('M d, Y') ?? $order->created_at->format('M d, Y')); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Items Ordered</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="info-row">
                <span class="info-label"><?php echo e($item->product_name); ?> <span style="color: #94a3b8; font-size: 13px;">x<?php echo e($item->quantity); ?></span></span>
                <span class="info-value">$<?php echo e(number_format($item->unit_price, 2)); ?></span>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <p style="color: #94a3b8; margin: 0;">No items found.</p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <div class="card">
        <div class="section-title">Totals</div>
        <div class="info-row">
            <span class="info-label">Subtotal</span>
            <span class="info-value">$<?php echo e(number_format($order->subtotal, 2)); ?></span>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if (! ($order->discount_total == 0)): ?>
            <div class="info-row">
                <span class="info-label">Discount</span>
                <span class="info-value" style="color: #10b981;">-$<?php echo e(number_format($order->discount_total, 2)); ?></span>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <div class="info-row">
            <span class="info-label">Shipping</span>
            <span class="info-value">$<?php echo e(number_format($order->shipping_total, 2)); ?></span>
        </div>
        <div class="info-row" style="border-bottom: none; padding-top: 14px;">
            <span class="info-label" style="font-weight: 700; color: #1e293b;">Total</span>
            <span class="info-value" style="font-weight: 700; color: #4f46e5; font-size: 16px;">$<?php echo e(number_format($order->total, 2)); ?></span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Shipping Address</div>
        <p style="margin: 0; color: #1e293b; line-height: 1.6;">
            <strong><?php echo e($order->shipping_name); ?></strong><br>
            <?php echo e($order->shipping_phone); ?><br>
            <?php echo e($order->shipping_address); ?>

        </p>
    </div>

    <p>If you have any questions, please reply to this email or contact our support team.</p>

    Thanks for shopping with us!<br>
    <strong><?php echo e(config('app.name', 'Shop Hub')); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\orders\customer.blade.php ENDPATH**/ ?>