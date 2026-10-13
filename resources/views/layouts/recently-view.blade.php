@php
    $recentlyViewed = session('recently_viewed', []);
    $recentProducts = collect();
    $wishlistIds = auth()->check()
        ? auth()->user()->wishlistItems()->pluck('product_id')->flip()->all()
        : [];

    if (!empty($recentlyViewed)) {
        $recentProducts = \App\Models\AdminProduct::query()
            ->with(['category', 'images', 'approvedReviews'])
            ->where('status', 'published')
            ->whereIn('id', $recentlyViewed)
            ->limit(8)
            ->get()
            ->sortBy(fn($product) => array_search($product->id, $recentlyViewed));
    }
@endphp

@if($recentProducts->isNotEmpty())
    <section class="py-5">
        <div class="container">
            <div class="shop-section-head d-flex justify-content-between align-items-center mb-4">
                <div>
                    <span class="shop-eyebrow">Keep Shopping</span>
                    <h2 class="shop-section-title">Recently Viewed</h2>
                </div>
                <button class="btn btn-sm btn-outline-secondary" onclick="clearRecentlyViewed()">
                    <i class="bi bi-x-lg me-1"></i>Clear
                </button>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($recentProducts as $product)
                    <div class="col">
                        <x-product-card :product="$product" :wishlist-ids="$wishlistIds ?? []" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

@push('scripts')
<script>
    function clearRecentlyViewed() {
        fetch('{{ route('recently-viewed.clear') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
</script>
@endpush
