@extends('layouts.main')

@push('title')
    <title>{{ $product->name }} | {{ config('app.name', 'Shop Hub') }}</title>
@endpush
@push('style')
    <style>
        .wishlist-button {
            min-width: 200px;
            height: 44px;
            padding: 0 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            white-space: nowrap;
        }
    </style>
@endpush
@section('meta_description', $product->short_description ?: \Illuminate\Support\Str::limit($product->description, 155))

@section('content')
    @php
        $image = $product->images->first();
        $price = $product->sale_price ?? $product->regular_price;
    @endphp
    <main class="container py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row ">
            {{-- Product Image --}}
            <div class="col-lg-6">
                <div class="shop-gallery">
                    <div class="shop-gallery-main">
                        <img src="{{ $image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg') }}"
                            alt="{{ $product->name }}">
                    </div>
                </div>
            </div>

            {{-- Product Details --}}
            <div class="col-lg-6">
                <div class="shop-buy-box p-4 rounded-4 border bg-white">
                    <p class="text-muted mb-2">{{ $product->category?->name }}</p>
                    <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

                    {{-- Vendor Info --}}
                    @if ($product->vendor && $product->vendor->isVendor())
                        <a href="{{ route('vendor.store', $product->vendor->id) }}"
                            class="d-flex align-items-center gap-2 mb-3 text-decoration-none vendor-detail-link">
                            @if ($product->vendor->vendorDetail?->logo)
                                <img src="{{ asset('storage/' . $product->vendor->vendorDetail->logo) }}"
                                    alt="{{ $product->vendor->vendorDetail->business_name }}" class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="vendor-detail-avatar">
                                    {{ strtoupper(substr($product->vendor->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <span
                                    class="text-dark fw-semibold">{{ $product->vendor->vendorDetail->business_name ?? $product->vendor->name }}</span>
                                @if ($product->vendor->isActive())
                                    <i class="bi bi-patch-check-fill text-primary ms-1" title="Verified Seller"></i>
                                @endif
                            </div>
                        </a>
                    @endif

                    <div class="d-flex align-items-center gap-3 mb-3 flex-wrap">
                        <span class="shop-price-lg">${{ number_format((float) $price, 2) }}</span>
                        @if ($product->sale_price && $product->sale_price < $product->regular_price)
                            <span class="shop-price-old">${{ number_format((float) $product->regular_price, 2) }}</span>
                            <span class="shop-price-off">
                                -{{ round((($product->regular_price - $product->sale_price) / $product->regular_price) * 100) }}%
                            </span>
                        @endif
                    </div>

                    <div class="text-warning mb-3">
                        @php $avgRating = $product->averageRating(); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= floor($avgRating))
                                <i class="bi bi-star-fill"></i>
                            @elseif ($i - 0.5 <= $avgRating)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                        <span class="text-muted ms-2">({{ $product->approvedReviews->count() }} Reviews)</span>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <strong>SKU:</strong>
                            <p class="text-secondary mb-0">{{ $product->sku }}</p>
                        </div>
                        <div class="col-sm-6">
                            <strong>Availability:</strong>
                            <div>
                                @if ($product->quantity > 0 && $product->stock_status === 'in_stock')
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if (session('warning'))
                        <div class="alert alert-warning rounded-3 mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
                        </div>
                    @endif

                    @if ($product->quantity <= 0 || $product->stock_status !== 'in_stock')
                        <div class="alert alert-warning rounded-3 mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>This product is out of stock.
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <button type="button" class="btn btn-outline-info btn-lg" onclick="navigator.clipboard.writeText('Name: {{ $product->name }}\nPrice: ${{ number_format((float) $price, 2) }}\n{{ $product->short_description }}'); alert('Details Copied!');">
                            <i class="bi bi-clipboard me-2"></i>Copy Details
                        </button>
                        <a href="{{ $image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg') }}" download class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-download me-2"></i>Download Picture
                        </a>
                        <form action="{{ route('user.reserve', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-bookmark me-2"></i>Reserve
                            </button>
                        </form>
                    </div>

                    {{-- Wishlist toggle --}}
                    @auth()
                        @php
                            $isInWishlist = isset($wishlistIds[$product->id]);
                        @endphp
                        <div class="mt-3">
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="btn {{ $isInWishlist ? 'btn-danger' : 'btn-outline-danger' }} wishlist-button">
                                    <i class="bi bi-heart{{ $isInWishlist ? '-fill' : '' }}"></i>
                                    <span>{{ $isInWishlist ? 'Remove from Wishlist' : '' }}</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3">
                            <a href="{{ route('login') }}" class="btn btn-outline-danger rounded-pill">
                                <i class="bi bi-heart me-1"></i>
                                Add to Wishlist
                            </a>
                        </div>
                    @endauth



                    {{-- Product Share & Compare --}}
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <x-product-share :product="$product" />
                        <button class="btn btn-sm btn-outline-secondary" onclick="addToCompare({{ $product->id }})">
                            <i class="bi bi-arrow-left-right me-1"></i>Compare
                        </button>
                    </div>
                </div>
            </div>


            {{-- Descriptions Below Image --}}

            <div class="col-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-3">About This Item</h3>
                        <p class="text-muted mb-3">{{ $product->short_description }}</p>
                        <div class="mt-3">{!! nl2br(e($product->description)) !!}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <h2 class="h4 fw-bold mt-5 mb-4">Customer Reviews</h2>
        @php $reviews = $product->approvedReviews; @endphp
        @if ($reviews->count() > 0)
            <div class="row g-4 mb-5">
                @foreach ($reviews as $review)
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($review->user?->image)
                                            <img src="{{ asset('storage/' . $review->user->image) }}"
                                                alt="{{ $review->user->name }}" class="rounded-circle"
                                                style="width: 36px; height: 36px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                style="width: 36px; height: 36px; font-size: 0.85rem; font-weight: 600;">
                                                {{ substr($review->user?->name ?? 'U', 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="small">{{ $review->user?->name ?? 'Anonymous' }}</strong>
                                            @if ($review->rating)
                                                <div class="text-warning small">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $review->rating)
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at?->diffForHumans() }}</small>
                                </div>
                                <p class="text-muted mb-0">{{ $review->comment }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-muted mb-5">No reviews yet for this product.</p>
        @endif

        @include('layouts.reviewes', ['product' => $product])

        {{-- Q&A Section --}}
        <div class="qa-section mt-5">
            <h2 class="h4 fw-bold mb-4"><i class="bi bi-question-circle me-2"></i>Customer Questions & Answers</h2>

            @if (session('success'))
                <div class="alert alert-success rounded-4 mb-4">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Ask a Question --}}
            @auth
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        <form action="{{ route('product.question', $product->id) }}" method="POST">
                            @csrf
                            <div class="d-flex align-items-start gap-3">
                                <div class="qa-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <textarea name="question" rows="2" class="form-control mb-2"
                                        placeholder="Have a question about this product? Ask the seller..." required></textarea>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bi bi-send me-1"></i>Submit Question
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info mb-4">
                    <i class="bi bi-info-circle me-2"></i><a href="{{ route('login') }}" class="alert-link">Sign in</a> to
                    ask a question about this product.
                </div>
            @endauth

            {{-- Existing Questions --}}
            @if ($questions && $questions->count() > 0)
                <div class="qa-list">
                    @foreach ($questions as $qa)
                        <div class="qa-item">
                            <div class="qa-question">
                                <div class="qa-avatar qa-avatar-q">Q</div>
                                <div class="qa-content">
                                    <p class="fw-semibold mb-1">{{ $qa->question }}</p>
                                    <small class="text-muted">Asked by {{ $qa->user->name ?? 'Customer' }} on
                                        {{ $qa->created_at?->format('M j, Y') }}</small>
                                </div>
                            </div>
                            @if ($qa->answer)
                                <div class="qa-answer">
                                    <div class="qa-avatar qa-avatar-a">A</div>
                                    <div class="qa-content">
                                        <p class="mb-1">{{ $qa->answer }}</p>
                                        <small class="text-muted">Answered by Admin on
                                            {{ $qa->answered_at?->format('M j, Y') }}</small>
                                    </div>
                                </div>
                            @else
                                <div class="qa-answer pending">
                                    <p class="text-muted mb-0"><i class="bi bi-hourglass me-1"></i>Awaiting seller
                                        response...</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-chat-square-text display-4 text-muted"></i>
                    <p class="text-muted mt-2">No questions yet. Be the first to ask!</p>
                </div>
            @endif
        </div>



        {{-- Related Products --}}
        <h2 class="h4 fw-bold mt-5 mb-4">Related Products</h2>
        <div class="row g-4">
            @foreach ($relatedProducts as $related)
                <div class="col-md-3">
                    <x-product-card :product="$related" :wishlist-ids="$wishlistIds ?? []" />
                </div>
            @endforeach
        </div>
    </main>


@endsection
