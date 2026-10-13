@extends('employee.layouts.main')

@push('title')
    <title>Products - Employee Portal</title>
    <style>
        .filter-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
        }
        .filter-card .form-control, .filter-card .form-select {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            font-size: 0.9rem;
        }
        .btn-search-blue {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-search-blue:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .products-table-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .product-img-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .btn-reserve {
            background-color: #22c55e;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-reserve:hover {
            background-color: #16a34a;
            color: #ffffff;
        }
        .btn-view-blue {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
            text-decoration: none;
        }
        .btn-view-blue:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .btn-fav {
            background-color: #f59e0b;
            color: #ffffff;
            border: none;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            white-space: nowrap;
        }
        .btn-fav:hover {
            background-color: #d97706;
            color: #ffffff;
        }
        .btn-fav.active {
            background-color: #dc2626;
        }
        .copy-btn {
            cursor: pointer;
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 6px 10px;
            transition: all 0.15s;
        }
        .copy-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Products</h2>
            <p class="text-muted">Category: <span class="badge bg-success text-uppercase">{{ str_replace('-', ' ', $currentCategory) }}</span></p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Filter Box Matching Video -->
        <div class="filter-card">
            <form action="{{ route('employee.products', $currentCategory) }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="product_code" class="form-control" placeholder="Search by product code..." value="{{ request('product_code') }}">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="market">
                            <option value="">Select Market</option>
                            <option value="US" {{ request('market') === 'US' ? 'selected' : '' }}>US</option>
                            <option value="UK" {{ request('market') === 'UK' ? 'selected' : '' }}>UK</option>
                            <option value="FR" {{ request('market') === 'FR' ? 'selected' : '' }}>FR</option>
                            <option value="AUS" {{ request('market') === 'AUS' ? 'selected' : '' }}>AUS</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="keyword" class="form-control" placeholder="Search by keyword..." value="{{ request('keyword') }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-search-blue w-100">
                            <i class="fas fa-search me-1"></i> Search Products
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Products Table (Laptop/Desktop View) -->
        <div class="products-table-card">
            <h5 class="fw-bold mb-4 text-dark">Active Products</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Seller</th>
                            <th>Market</th>
                            <th>Sale Limit</th>
                            <th>Today Remaining</th>
                            <th>Total Remaining</th>
                            <th>Commission</th>
                            <th>Keyword</th>
                            <th>Available Refund</th>
                            <th>Product ID</th>
                            <th>Image</th>
                            <th>Copy Info</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        @php
                            $isFav = in_array($product->id, $favorites);
                            $img = $product->images->first()?->image;
                            $imgUrl = $img ? asset('storage/' . $img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200';
                            $copyText = "Product ID: {$product->id}\nTitle: {$product->name}\nPrice: $" . number_format($product->sale_price ?? $product->regular_price ?? 0, 2) . "\nSKU: {$product->sku}";
                        @endphp
                        <tr>
                            <td>
                                <a href="https://wa.me/923001234567" target="_blank" class="btn btn-sm btn-outline-success rounded-circle p-1" title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                                <small class="text-muted d-block mt-1">563</small>
                            </td>
                            <td><span class="badge bg-light text-dark border">US</span></td>
                            <td class="fw-semibold">2</td>
                            <td class="text-success fw-bold">2</td>
                            <td class="text-primary fw-bold">{{ $product->quantity ?? 10 }}</td>
                            <td class="fw-bold text-dark">${{ number_format((float)($product->regular_price * 0.1), 2) }}</td>
                            <td>
                                <span class="d-inline-block text-truncate" style="max-width: 140px;" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </span>
                            </td>
                            <td><span class="badge bg-primary-subtle text-primary border">Paypal</span></td>
                            <td class="fw-bold text-secondary">#{{ $product->id }}</td>
                            <td>
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="product-img-thumb">
                            </td>
                            <td>
                                <button type="button" class="copy-btn" onclick="navigator.clipboard.writeText(`{{ addslashes($copyText) }}`); alert('Product info copied to clipboard!');" title="Copy Info">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1">
                                    <form action="{{ route('employee.reservations.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="btn btn-reserve">
                                            Reserve Now
                                        </button>
                                    </form>

                                    <a href="{{ route('employee.product.detail', $product->id) }}" class="btn btn-view-blue">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>

                                    <form action="{{ route('employee.product.favorite.toggle', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-fav {{ $isFav ? 'active' : '' }}" title="{{ $isFav ? 'Remove Favorite' : 'Add Favorite' }}">
                                            <i class="bi {{ $isFav ? 'bi-star-fill' : 'bi-star' }}"></i> Favorite
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-2 d-block mb-2 text-secondary"></i>
                                No products found in this category.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
