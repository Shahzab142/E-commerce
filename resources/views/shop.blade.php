@extends('layouts.main')

@push('title')
    <title>Shop - {{ config('app.name', 'Shop Hub') }}</title>
@endpush

@section('content')

@include('partials.hero-slider')

<div class="container-fluid px-xl-5 py-4">

    {{-- Horizontal Categories Rail (Daraz Style) --}}
    <div class="shop-cat-rail mb-4 pb-2 border-bottom">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link {{ !request('category') ? 'active fw-bold' : '' }}" href="{{ url('shop') }}">
                    All Categories
                </a>
            </li>
            @forelse ($categories as $category)
                <li class="nav-item">
                    <a class="nav-link {{ request('category') === $category->slug ? 'active fw-bold' : '' }}" href="{{ url('category/' . $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @empty
            @endforelse
        </ul>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Just For You</h4>
        <div class="d-flex align-items-center gap-3">
            <form method="GET" action="{{ route('search') }}" class="d-flex">
                <input type="text" name="q" class="form-control form-control-sm rounded-pill px-3"
                       placeholder="Search in Shop..." value="{{ request('q') }}">
            </form>
            <select name="sort" class="form-select form-select-sm w-auto rounded-pill px-3" onchange="updateSort(this.value)">
                <option value="newest" {{ ($sort ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_low" {{ ($sort ?? 'newest') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ ($sort ?? 'newest') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="rating" {{ ($sort ?? 'newest') === 'rating' ? 'selected' : '' }}>Top Rated</option>
            </select>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Product Grid (Daraz uses 6 columns on large screens) --}}
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 g-2">
        @forelse ($products as $product)
            <div class="col mb-3">
                <x-product-card :product="$product" :wishlist-ids="$wishlistIds" />
            </div>
        @empty
            <div class="col-12 text-center py-5 w-100">
                <div class="bg-white p-5 rounded border">
                    <i class="bi bi-box fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No products found.</h5>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>

</div>

<script>
    function updateSort(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }
</script>
@endsection