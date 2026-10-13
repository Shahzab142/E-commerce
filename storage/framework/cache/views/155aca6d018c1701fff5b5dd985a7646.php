<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($frequentlyBoughtTogether && $frequentlyBoughtTogether->count() > 0): ?>
    <section class="frequently-bought-section mt-5">
        <h2 class="h4 fw-bold mb-4"><i class="bi bi-bag-plus me-2"></i>Frequently Bought Together</h2>
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        
                        <div class="fbt-item">
                            <img src="<?php echo e($product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/products/7.jpg')); ?>" alt="<?php echo e($product->name); ?>" class="fbt-image">
                            <p class="fbt-name mb-0"><?php echo e(Str::limit($product->name, 20)); ?></p>
                            <p class="fbt-price fw-bold text-danger mb-0">$<?php echo e(number_format($product->currentPrice(), 2)); ?></p>
                        </div>
                        <i class="bi bi-plus-circle fbt-plus"></i>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $frequentlyBoughtTogether; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <div class="fbt-item">
                                <img src="<?php echo e($related->images->first() ? asset('storage/' . $related->images->first()->image) : asset('assets/images/products/7.jpg')); ?>" alt="<?php echo e($related->name); ?>" class="fbt-image">
                                <p class="fbt-name mb-0"><?php echo e(Str::limit($related->name, 20)); ?></p>
                                <p class="fbt-price fw-bold text-danger mb-0">$<?php echo e(number_format($related->currentPrice(), 2)); ?></p>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$loop->last): ?><i class="bi bi-plus-circle fbt-plus"></i><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fbt-summary">
                        <p class="text-muted mb-2">Total price for all items:</p>
                        <p class="fbt-total">$<?php echo e(number_format($fbtTotal, 2)); ?></p>
                        <button class="btn btn-primary w-100" onclick="addAllToCart()">
                            <i class="bi bi-cart-plus me-2"></i>Add all to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\layouts\frequently-bought.blade.php ENDPATH**/ ?>