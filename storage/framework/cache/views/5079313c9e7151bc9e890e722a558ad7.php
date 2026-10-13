<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Order Shipped
    <?php $__env->endSlot(); ?>

    <h2>Your Order Has Shipped!</h2>
    <p>Great news! Your order <strong>#<?php echo e($order->order_number); ?></strong> has been shipped and is on its way to you.</p>

    <div class="card">
        <div class="section-title">Shipping Details</div>
        <div class="info-row">
            <span class="info-label">Shipped On</span>
            <span class="info-value"><?php echo e($shippedDate); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Shipping Method</span>
            <span class="info-value"><?php echo e(ucfirst(str_replace('_', ' ', $order->shipping_method))); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Tracking Number</span>
            <span class="info-value"><?php echo e($order->payment_reference ?? 'Not available yet'); ?></span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">What was in your order?</div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="info-row">
                <span class="info-label"><?php echo e($item->product_name); ?> <span style="color: #94a3b8; font-size: 13px;">x<?php echo e($item->quantity); ?></span></span>
                <span class="info-value">$<?php echo e(number_format($item->unit_price, 2)); ?></span>
            </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    <div class="card">
        <div class="section-title">Order Total</div>
        <div class="info-row" style="border-bottom: none; padding-top: 14px;">
            <span class="info-label" style="font-weight: 700; color: #1e293b;">Total</span>
            <span class="info-value" style="font-weight: 700; color: #4f46e5; font-size: 16px;">$<?php echo e(number_format($order->total, 2)); ?></span>
        </div>
    </div>

    <a href="<?php echo e(url('/track-order')); ?>" class="btn">Track Your Order</a>

    <p>If you have any questions about your shipment, please contact our support team.</p>

    Thanks for your business!<br>
    <strong><?php echo e(config('app.name', 'Shop Hub')); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\orders\shipped.blade.php ENDPATH**/ ?>