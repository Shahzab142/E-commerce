@extends('layouts.main')

@push('title')
    <title>{{ $category->name }} | {{ config('app.name', 'Shop Hub') }}</title>
@endpush
@section('meta_description', $category->short_description ?: 'Shop ' . $category->name . ' products at ' .
    config('app.name', 'Shop Hub') . '.')

@section('content')
    <main class="container py-5">
        <header class="mb-4">
            <p class="text-uppercase text-primary fw-semibold mb-1">Collection</p>
            <h1 class="fw-bold">{{ $category->name }}</h1>
            <p class="text-muted">{{ $category->description ?: $category->short_description }}</p>
        </header>
        <div class="row g-4">
            @forelse ($products as $product)
                @php
                    $image = $product->images->first();
                    $price = $product->sale_price ?? $product->regular_price;
                @endphp
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <article class="card h-100 border-0 shadow-sm product-card">
                        <div class="product-image">
                            <img src="{{ $image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg') }}"
                                class="card-img-top" alt="{{ $product->name }}">
                            <a href="{{ url('/product/' . $product->id) }}" class="btn btn-light btn-sm" title="View Details">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ $image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg') }}" download class="btn btn-light btn-sm ms-1" title="Download Image">
                                <i class="bi bi-download"></i>
                            </a>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">{{ $product->name }}</h5>
                            <p class="text-muted small flex-grow-1">{{ $product->short_description }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong class="text-danger">${{ number_format((float) $price, 2) }}</strong>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-pill" onclick="navigator.clipboard.writeText('Name: {{ $product->name }}\nPrice: ${{ number_format((float) $price, 2) }}\n{{ $product->short_description }}'); alert('Details Copied!');">
                                        <i class="bi bi-clipboard me-1"></i>Copy Details
                                    </button>
                                    <form action="{{ route('user.reserve', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm rounded-pill">
                                            <i class="bi bi-bookmark me-1"></i>Reserve
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted text-center py-5">No published products are available in this category.</p>
                </div>
            @endforelse
        </div>
    </main>
@endsection
