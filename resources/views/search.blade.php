@extends('layouts.main')

@push('title')
    <title>Search - {{ config('app.name', 'Shop Hub') }}</title>
@endpush

@section('meta_description', $query !== ''
    ? 'Search results for "' . $query . '" on ' . config('app.name', 'Shop Hub') . '.'
    : 'Browse products, filters and deals on ' . config('app.name', 'Shop Hub') . '.')

@section('content')
<div class="container py-4">
    <div class="row">

        <div class="col-12 mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}">Shop</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
            <h2 class="h4 fw-bold mb-1">
                <i class="bi bi-search me-2 text-primary"></i>Search Results
                @if ($query !== '')
                    <span class="text-muted small fw-normal">for "{{ $query }}"</span>
                @endif
            </h2>
            <p class="text-muted small mb-0">
                {{ $products->total() }} product{{ $products->total() === 1 ? '' : 's' }} found
            </p>
        </div>

        <div class="col-lg-3">
            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-2"></i>Filters</h5>
                </div>
                <div class="card-body p-2">
                    <ul class="list-unstyled">
                        @forelse ($categories as $category)
                            @php
                                $isActive = request('category') === $category->slug;
                            @endphp
                            <li>
                                <a href="{{ url('category/' . $category->slug) }}"
                                    class="d-block py-2 px-3 text-dark text-decoration-none small {{ $isActive ? 'fw-semibold text-primary' : '' }}">
                                    {{ $category->name }}
                                    <span class="text-muted small float-end">({{ $category->products_count }})</span>
                                </a>
                            </li>
                        @empty
                            <li class="px-3 py-2 text-muted small">No categories found.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-currency-dollar me-2"></i>Price Range</h5>
                </div>
                <div class="card-body">
                    <form id="price-filter-form" class="d-grid gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" name="min" class="form-control form-control-sm"
                                   placeholder="Min $" value="{{ request('min', '') }}" min="0">
                            <input type="number" name="max" class="form-control form-control-sm"
                                   placeholder="Max $" value="{{ request('max', '') }}" min="0">
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">Apply</button>
                        @if (request('min') || request('max') || request('rating') || request('availability'))
                            <a href="{{ route('search') }}?q={{ request('q', '') }}"
                               class="btn btn-sm btn-outline-secondary">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-star me-2"></i>Rating</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-grid gap-2">
                        @foreach ([5 => '5 Stars', 4 => '4 Stars & up', 3 => '3 Stars & up', 2 => '2 Stars & up', 1 => '1 Star & up'] as $value => $label)
                            <a href="{{ route('search', array_filter(['q' => $query, 'rating' => $value])) }}"
                               class="btn btn-sm {{ request('rating') == $value ? 'btn-primary' : 'btn-outline-secondary' }} text-start">
                                <i class="bi bi-star-fill text-warning me-1"></i>{{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card shop-filter-card mb-4">
                <div class="card-header py-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Availability</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-grid gap-2">
                        <a href="{{ route('search', array_filter(['q' => $query, 'availability' => 'in_stock'])) }}"
                           class="btn btn-sm {{ request('availability') === 'in_stock' ? 'btn-primary' : 'btn-outline-secondary' }} text-start">
                            In stock
                        </a>
                        <a href="{{ route('search', array_filter(['q' => $query, 'availability' => 'on_sale'])) }}"
                           class="btn btn-sm {{ request('availability') === 'on_sale' ? 'btn-primary' : 'btn-outline-secondary' }} text-start">
                            On sale
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <div>
                    <h2 class="h5 fw-bold mb-0">Results</h2>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <form method="GET" action="{{ route('search') }}" class="d-flex">
                        <input type="text" name="q" class="form-control form-control-sm"
                               placeholder="Search products..." value="{{ $query }}" required>
                    </form>
                    <select name="sort" class="form-select form-select-sm w-auto" onchange="updateSort(this.value)">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="price_low" {{ $sort === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ $sort === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Top Rated</option>
                    </select>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @forelse ($products as $product)
                    <div class="col">
                        <x-product-card :product="$product" :wishlist-ids="$wishlistIds ?? []" />
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                        <p class="text-muted mb-0">No products found for "{{ $query ?: 'the selected filters' }}".</p>
                        <a href="{{ route('shop') }}" class="btn btn-sm btn-primary mt-2">Browse all products</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function updateSort(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        window.location.href = url.toString();
    }

    document.getElementById('price-filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        const minPrice = this.min.value;
        const maxPrice = this.max.value;
        if (minPrice) url.searchParams.set('min', minPrice);
        else url.searchParams.delete('min');
        if (maxPrice) url.searchParams.set('max', maxPrice);
        else url.searchParams.delete('max');
        window.location.href = url.toString();
    });
</script>
@endsection
