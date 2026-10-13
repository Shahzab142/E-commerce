<?php $__env->startPush('title'); ?>
    <title>Checkout</title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        
        <div class="checkout-progress-wrapper mb-5">
            <div class="checkout-progress">
                <div class="checkout-step completed">
                    <div class="checkout-step-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <div class="checkout-step-label">Cart</div>
                </div>
                <div class="checkout-step-line completed"></div>
                <div class="checkout-step active">
                    <div class="checkout-step-icon">2</div>
                    <div class="checkout-step-label">Checkout</div>
                </div>
                <div class="checkout-step-line"></div>
                <div class="checkout-step">
                    <div class="checkout-step-icon">3</div>
                    <div class="checkout-step-label">Payment</div>
                </div>
                <div class="checkout-step-line"></div>
                <div class="checkout-step">
                    <div class="checkout-step-icon">4</div>
                    <div class="checkout-step-label">Confirmation</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h1 class="h2 fw-bold"><i class="bi bi-bag-check-fill text-warning me-2"></i>Checkout</h1>
            <a href="<?php echo e(route('cart.list', 'products')); ?>" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i>Back to Cart
            </a>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
            <div class="alert alert-danger"><strong>Please correct the highlighted fields.</strong></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i><strong><?php echo e(session('error')); ?></strong></div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <form action="<?php echo e(route('checkout.place', $slug ?? 'products')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-4">
                <div class="col-lg-8">
                    
                    <div class="card checkout-card mb-4">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-4"><i class="bi bi-geo-alt me-2"></i>Shipping Address</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Full Name</label>
                                    <input id="name" name="name" class="form-control"
                                        value="<?php echo e(old('name', $checkoutUser?->name)); ?>" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email Address</label>
                                    <input id="email" name="email" type="email" class="form-control"
                                        value="<?php echo e(old('email', $checkoutUser?->email)); ?>" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone Number</label>
                                    <input id="phone" name="phone" class="form-control"
                                        value="<?php echo e(old('phone', $checkoutUser?->phone)); ?>" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="city">City</label>
                                    <input id="city" name="city" class="form-control" value="<?php echo e(old('city', $checkoutUser?->address)); ?>" required>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="address">Complete Address</label>
                                    <textarea id="address" name="address" rows="3" class="form-control" required><?php echo e(old('address', $checkoutUser?->address)); ?></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card checkout-card mb-4">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-4"><i class="bi bi-truck me-2"></i>Delivery Method</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="shop-option-row">
                                        <input class="form-check-input" id="standard" type="radio" name="shipping" value="standard"
                                            <?php if(old('shipping', 'standard') === 'standard'): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="standard">
                                            <strong>Standard Delivery</strong>
                                            <small class="d-block text-muted">5-7 business days</small>
                                        </label>
                                        <span class="ms-auto fw-bold">$10</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="shop-option-row">
                                        <input class="form-check-input" id="express" type="radio" name="shipping" value="express"
                                            <?php if(old('shipping') === 'express'): echo 'checked'; endif; ?>>
                                        <label class="form-check-label" for="express">
                                            <strong>Express Delivery</strong>
                                            <small class="d-block text-muted">1-2 business days</small>
                                        </label>
                                        <span class="ms-auto fw-bold">$20</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card checkout-card mb-4">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-4"><i class="bi bi-credit-card me-2"></i>Payment Method</h2>


                            <div class="row g-3">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = ['cod' => 'Cash on Delivery', 'card' => 'Credit / Debit Card']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="col-md-6">
                                        <div class="shop-option-row">
                                            <input class="form-check-input payment-method-radio" id="payment-<?php echo e($value); ?>" type="radio" name="payment_method"
                                                value="<?php echo e($value); ?>" data-method="<?php echo e($value); ?>"
                                                <?php if(old('payment_method', 'cod') === $value): echo 'checked'; endif; ?>">
                                            <label class="form-check-label" for="payment-<?php echo e($value); ?>">
                                                <i class="bi bi-<?php echo e($value === 'cod' ? 'cash' : 'credit-card'); ?> me-2"></i><?php echo e($label); ?>

                                            </label>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <div class="col-md-6">
                                        <div class="shop-option-row">
                                            <input class="form-check-input payment-method-radio" id="payment-<?php echo e($value); ?>" type="radio" name="payment_method"
                                                value="<?php echo e($value); ?>" data-method="<?php echo e($value); ?>"
                                                <?php if(old('payment_method') === $value): echo 'checked'; endif; ?>">
                                            <label class="form-check-label" for="payment-<?php echo e($value); ?>">
                                                <i class="bi bi-<?php echo e($method['type'] === 'bank' ? 'bank' : ($method['type'] === 'easypaisa' ? 'phone' : 'wallet2')); ?> me-2"></i><?php echo e($method['label']); ?>

                                            </label>
                                        </div>
                                    </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            </div>

                            <div id="payment-details" class="mt-3" style="display: none;">
                                <div id="payment-detail-content" class="shop-payment-details"></div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card checkout-card">
                        <div class="card-body">
                            <label class="form-label" for="notes">Order Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Any special instructions for your order..."><?php echo e(old('notes')); ?></textarea>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4">
                    <div class="card checkout-card summary">
                        <div class="card-body">
                            <h2 class="h5 fw-bold mb-4"><i class="bi bi-receipt-cutoff text-warning me-1"></i>Order Summary</h2>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    $quantity = (int) $cart[$product->id];
                                    $price = (float) ($product->sale_price ?? $product->regular_price);
                                ?>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-truncate me-2"><?php echo e($product->name); ?> x<?php echo e($quantity); ?></span>
                                    <strong>$<?php echo e(number_format($price * $quantity, 2)); ?></strong>
                                </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span><strong>$<?php echo e(number_format($subtotal, 2)); ?></strong>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupon): ?>
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount <span class="badge bg-light text-dark border ms-1"><?php echo e($coupon->code); ?></span></span>
                                    <strong>-$<?php echo e(number_format($discount, 2)); ?></strong>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <p class="small text-muted mb-3">Shipping is added based on the delivery method you choose above.</p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($coupon): ?>
                                <div class="d-flex align-items-center justify-content-between border rounded-3 p-2 mb-3">
                                    <span class="fw-semibold small"><i class="bi bi-tag-fill text-warning me-1"></i><?php echo e($coupon->code); ?> applied</span>
                                    <a href="<?php echo e(route('cart.list', $slug ?? 'products')); ?>" class="small text-decoration-none">Change</a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-lock-fill me-1"></i>Place Order</button>

                            <div class="text-center mt-3">
                                <i class="bi bi-shield-lock-fill text-success"></i>
                                <p class="small text-muted mb-0">Your payment information is encrypted and secure.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const paymentDetails = <?php echo json_encode($paymentMethods, 15, 512) ?>;


        function updatePaymentDetails() {
            const selected = document.querySelector('input[name="payment_method"]:checked');
            const detailsDiv = document.getElementById('payment-details');
            const contentDiv = document.getElementById('payment-detail-content');

            if (!selected || !paymentDetails[selected.value]) {
                detailsDiv.style.display = 'none';
                contentDiv.innerHTML = '';
                return;
            }

            const method = paymentDetails[selected.value];
            let html = '';

            if (method.type === 'easypaisa') {
                html = `<div class="text-center">
                    <h6 class="fw-bold mb-2">Easypaisa Payment Details</h6>
                    <p class="mb-1"><strong>Account Title:</strong> ${method.account_title || 'N/A'}</p>
                    <p class="mb-0"><strong>Number:</strong> ${method.number}</p>
                    <small class="text-muted d-block mt-2">Send payment to this Easypaisa account. Your order will be confirmed upon payment verification.</small>
                </div>`;
            } else if (method.type === 'jazzcash') {
                html = `<div class="text-center">
                    <h6 class="fw-bold mb-2">JazzCash Payment Details</h6>
                    <p class="mb-1"><strong>Account Title:</strong> ${method.account_title || 'N/A'}</p>
                    <p class="mb-0"><strong>Number:</strong> ${method.number}</p>
                    <small class="text-muted d-block mt-2">Send payment to this JazzCash account. Your order will be confirmed upon payment verification.</small>
                </div>`;
            } else if (method.type === 'bank') {
                html = `<div>
                    <h6 class="fw-bold mb-2">Bank Transfer Details</h6>
                    <p class="mb-1"><strong>Bank:</strong> ${method.bank_name || 'N/A'}</p>
                    <p class="mb-1"><strong>Account Title:</strong> ${method.account_title || 'N/A'}</p>
                    <p class="mb-1"><strong>Account Number:</strong> ${method.account_number || 'N/A'}</p>
                    ${method.iban ? `<p class="mb-0"><strong>IBAN:</strong> ${method.iban}</p>` : ''}
                    <small class="text-muted d-block mt-2">Please include your order number in the bank transfer reference.</small>
                </div>`;
            }

            contentDiv.innerHTML = html;
            detailsDiv.style.display = 'block';
        }

        function setStepState(steps, state) {
            steps.forEach((index) => {
                const step = document.querySelectorAll('.checkout-step')[index];
                const line = document.querySelectorAll('.checkout-step-line')[index];
                if (!step) return;
                step.classList.remove('active', 'completed');
                if (state) {
                    step.classList.add(state);
                }
                if (line) {
                    line.classList.remove('completed');
                    if (state === 'completed') {
                        line.classList.add('completed');
                    }
                }
            });
        }

        function markCheckoutComplete() {
            setStepState([1], 'completed');
            setStepState([2], 'active');
        }

        function markPaymentComplete() {
            setStepState([1, 2], 'completed');
            setStepState([3], 'active');
        }

        document.querySelectorAll('input[name="shipping"]').forEach(radio => {
            radio.addEventListener('change', markCheckoutComplete);
        });

        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', () => {
                updatePaymentDetails();
                markPaymentComplete();
            });
        });

        const checkoutForm = document.querySelector('form[action*="checkout"]');
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', () => {
                setStepState([1, 2, 3], 'completed');
                setStepState([3], 'active');
            });
        }

        updatePaymentDetails();
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\checkout.blade.php ENDPATH**/ ?>