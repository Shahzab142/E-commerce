@props(['product', 'showBadge' => true, 'wishlistIds' => []])

@php
    $image = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
    $currentPrice = $product->currentPrice();
    $discount = $product->discountPercent();
    $rating = $product->averageRating();
    $reviewCount = $product->approvedReviews->count();
    $isInWishlist = isset($wishlistIds[$product->id]);
    $vendor = null;
@endphp

<div class="product-card h-100">
    <div class="product-image">
        <a href="{{ route('product.detail', $product->id) }}" class="d-block text-decoration-none">
            @if ($image)
                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" loading="lazy">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                    <i class="bi bi-image fs-1 text-muted"></i>
                </div>
            @endif
        </a>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="mt-1">
            <a href="{{ route('product.detail', $product->id) }}" class="text-decoration-none product-name" title="{{ $product->name }}">
                {{ $product->name }}
            </a>
        </h5>

        <div class="mt-auto">
            @if ($discount > 0)
                <div class="price-current">Rs. {{ number_format($currentPrice, 0) }}</div>
                <div class="price-row mt-1">
                    <span class="price-regular">Rs. {{ number_format((float) $product->regular_price, 0) }}</span>
                    <span class="price-off">-{{ $discount }}%</span>
                </div>
            @else
                <div class="price-current">Rs. {{ number_format($currentPrice, 0) }}</div>
            @endif

            @if ($rating > 0)
                <div class="rating-stars mt-1">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($rating))
                            <i class="bi bi-star-fill"></i>
                        @elseif ($i - 0.5 <= $rating)
                            <i class="bi bi-star-half"></i>
                        @else
                            <i class="bi bi-star"></i>
                        @endif
                    @endfor
                    <span class="text-muted" style="font-size: 0.7rem;">({{ $reviewCount }})</span>
                </div>
            @endif
        </div>
    </div>
</div>
