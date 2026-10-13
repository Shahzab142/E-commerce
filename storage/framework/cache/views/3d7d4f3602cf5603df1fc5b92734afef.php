<?php $__env->startPush('title'); ?>
    <title>FAQs - <?php echo e(config('app.name', 'Shop Hub')); ?></title>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Support</span>
                <h1 class="display-5 fw-bold mb-3">Frequently Asked Questions</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Everything you need to know about shopping with us. Can't find what you're looking for? Contact our support team.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion accordion-flush shadow-sm" id="faqAccordion">
                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true">
                                <i class="bi bi-truck me-2 text-primary"></i> How long does delivery take?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">Standard delivery takes 3-5 business days. Express delivery is available for select areas and takes 1-2 business days. You'll receive a tracking link once your order is dispatched.</div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false">
                                <i class="bi bi-credit-card me-2 text-primary"></i> What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">We accept credit/debit cards, Easypaisa, JazzCash, bank transfers, and cash on delivery for select locations. All payments are secured with SSL encryption.</div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false">
                                <i class="bi bi-box-arrow-in-right me-2 text-primary"></i> How do I return a product?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">You can request a return within 7 days of delivery. Go to your order details, select the item, and choose a reason. Our team will review and provide a prepaid return label if approved.</div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false">
                                <i class="bi bi-shield-check me-2 text-primary"></i> Are my payments secure?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">Yes. We use industry-standard SSL encryption and secure payment gateways. We do not store your full card details on our servers.</div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false">
                                <i class="bi bi-arrow-repeat me-2 text-primary"></i> Can I cancel my order?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">Yes, you can cancel your order before it is shipped. Once shipped, cancellation is no longer possible, but you can still return the item after delivery.</div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border-0 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header" id="faq6">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false">
                                <i class="bi bi-tag me-2 text-primary"></i> Do you offer discounts or coupons?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">Yes! We regularly offer seasonal sales, coupon codes, and special promotions for new and returning customers. Subscribe to our newsletter to stay updated.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Administrator\Desktop\E_commerce\ecommerce-laravel-project\ecommerce-laravel-project\resources\views\faqs.blade.php ENDPATH**/ ?>