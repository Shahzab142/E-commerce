<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Flash Sale</h2>
            </div>
            <a href="{{ route('shop') }}" class="view-all text-decoration-none fw-semibold">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        @if ($topDeals->isNotEmpty())
            <div class="row g-4">
                @foreach ($topDeals as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <x-product-card :product="$product" :wishlist-ids="$wishlistIds" />
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <p class="text-muted">No top deals available right now. Check back later!</p>
            </div>
        @endif
    </div>
</section>
