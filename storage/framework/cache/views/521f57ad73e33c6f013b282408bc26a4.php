<?php $__env->startComponent('components.email-layout'); ?>
    <?php $__env->slot('headerSubtitle'); ?>
        Delivery Confirmation
    <?php $__env->endSlot(); ?>

    <h2>Your Order Has Been Delivered!</h2>
    <p>Congratulations! Your order <strong>#<?php echo e($order->order_number); ?></strong> has been successfully delivered.</p>

    <div class="card">
        <div class="section-title">Delivery Details</div>
        <div class="info-row">
            <span class="info-label">Delivered On</span>
            <span class="info-value"><?php echo e($deliveryDate); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Shipping Method</span>
            <span class="info-value"><?php echo e(ucfirst(str_replace('_', ' ', $order->shipping_method))); ?></span>
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

    <p>We hope you're happy with your purchase! If there are any issues with your order, please contact us right away so we can make it right.</p>

    <a href="<?php echo e(url('/orders')); ?>" class="btn">View Your Orders</a>

    Thank you for choosing us!<br>
    <strong><?php echo e(config('app.name', 'Shop Hub')); ?></strong>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\emails\orders\delivered.blade.php ENDPATH**/ ?>