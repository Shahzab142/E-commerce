@props(['product'])

@if($product->isInStock())
<div class="subscribe-save-card mt-4">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="subscribe-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-1">Subscribe & Save</h6>
                    <p class="text-muted small mb-0">Get 10% off + free shipping on regular deliveries</p>
                </div>
            </div>
            <div class="subscription-options">
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-none" value="none" checked>
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-none">
                        <span>One-time purchase</span>
                        <span class="fw-bold">${{ number_format($product->currentPrice(), 2) }}</span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-weekly" value="weekly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-weekly">
                        <span>Every week</span>
                        <span>
                            <span class="fw-bold text-success">${{ number_format($product->currentPrice() * 0.9, 2) }}</span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-monthly" value="monthly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-monthly">
                        <span>Every month</span>
                        <span>
                            <span class="fw-bold text-success">${{ number_format($product->currentPrice() * 0.9, 2) }}</span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
                <div class="form-check subscription-option">
                    <input class="form-check-input" type="radio" name="subscription" id="sub-bimonthly" value="bimonthly">
                    <label class="form-check-label d-flex justify-content-between w-100" for="sub-bimonthly">
                        <span>Every 2 months</span>
                        <span>
                            <span class="fw-bold text-success">${{ number_format($product->currentPrice() * 0.9, 2) }}</span>
                            <small class="badge bg-success ms-1">Save 10%</small>
                        </span>
                    </label>
                </div>
            </div>
            <p class="text-muted small mt-2 mb-0">
                <i class="bi bi-info-circle me-1"></i>Cancel anytime. No commitment required.
            </p>
        </div>
    </div>
</div>

@push('styles')
<style>
    .subscribe-save-card .form-check-input {
        display: none;
    }
    .subscription-option {
        padding: 0.75rem 1rem;
        border: 2px solid var(--shop-gray-200);
        border-radius: var(--shop-radius);
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .subscription-option:hover {
        border-color: var(--shop-primary);
    }
    .subscription-option:has(input:checked) {
        border-color: var(--shop-green);
        background: var(--shop-green-soft);
    }
    .subscribe-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--shop-green-soft);
        color: var(--shop-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
</style>
@endpush
@endif