@if($frequentlyBoughtTogether && $frequentlyBoughtTogether->count() > 0)
    <section class="frequently-bought-section mt-5">
        <h2 class="h4 fw-bold mb-4"><i class="bi bi-bag-plus me-2"></i>Frequently Bought Together</h2>
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="row align-items-center g-4">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        {{-- Main Product --}}
                        <div class="fbt-item">
                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->image) : asset('assets/images/products/7.jpg') }}" alt="{{ $product->name }}" class="fbt-image">
                            <p class="fbt-name mb-0">{{ Str::limit($product->name, 20) }}</p>
                            <p class="fbt-price fw-bold text-danger mb-0">${{ number_format($product->currentPrice(), 2) }}</p>
                        </div>
                        <i class="bi bi-plus-circle fbt-plus"></i>
                        {{-- Related Products --}}
                        @foreach($frequentlyBoughtTogether as $related)
                            <div class="fbt-item">
                                <img src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->image) : asset('assets/images/products/7.jpg') }}" alt="{{ $related->name }}" class="fbt-image">
                                <p class="fbt-name mb-0">{{ Str::limit($related->name, 20) }}</p>
                                <p class="fbt-price fw-bold text-danger mb-0">${{ number_format($related->currentPrice(), 2) }}</p>
                            </div>
                            @if(!$loop->last)<i class="bi bi-plus-circle fbt-plus"></i>@endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fbt-summary">
                        <p class="text-muted mb-2">Total price for all items:</p>
                        <p class="fbt-total">${{ number_format($fbtTotal, 2) }}</p>
                        <button class="btn btn-primary w-100" onclick="addAllToCart()">
                            <i class="bi bi-cart-plus me-2"></i>Add all to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif