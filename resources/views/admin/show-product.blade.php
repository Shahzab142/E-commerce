@extends('admin.layouts.main')

@push('title')
    <title>{{ $prod->name }} - Product Detail</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">

        <main>

            {{-- Page Header --}}
            <div class="container-fluid bg-light py-5 border-bottom">

                <div class="container text-center">

                    <h1 class="display-5 fw-bold">

                        <i class="bi bi-card-text text-primary me-2"></i>

                        Product Detail

                    </h1>

                    <p class="text-muted">
                        Product Information
                    </p>

                </div>

            </div>


            {{-- Product Details --}}
            <section class="py-5">

                <div class="container">

                    <div class="card border-0 shadow-lg rounded-4">

                        <div class="row g-0">


                            {{-- Product Image --}}
                            <div class="col-lg-5">

                                <div class="p-4">

                                    @php
                                        $productImage = $prod->images->first();
                                    @endphp


                                    @if ($productImage)
                                        <img src="{{ asset('storage/' . $productImage->image) }}"
                                            class="img-fluid rounded-4 w-100" alt="{{ $prod->name }}">
                                    @else
                                        <div class="text-center text-muted py-5">

                                            <i class="bi bi-image fs-1"></i>

                                            <p class="mt-2">
                                                No Image Available
                                            </p>

                                        </div>
                                    @endif

                                </div>

                            </div>


                            {{-- Product Details --}}
                            <div class="col-lg-7">

                                <div class="card-body p-4 p-lg-5">


                                    {{-- Product Name --}}
                                    <h2 class="fw-bold mt-3">

                                        {{ $prod->name }}

                                    </h2>


                                    {{-- Product Status --}}
                                    <div class="mb-3">

                                        @if ($prod->status == 'published')
                                            <span class="badge bg-success">
                                                Published
                                            </span>
                                        @elseif ($prod->status == 'draft')
                                            <span class="badge bg-secondary">
                                                Draft
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Hidden
                                            </span>
                                        @endif

                                    </div>


                                    {{-- Price --}}
                                    <h3 class="text-danger fw-bold">

                                        Rs.
                                        {{ number_format($prod->sale_price ?? $prod->regular_price, 2) }}


                                        @if ($prod->sale_price)
                                            <small class="text-muted text-decoration-line-through fs-5 ms-2">

                                                Rs.
                                                {{ number_format($prod->regular_price, 2) }}

                                            </small>
                                        @endif

                                    </h3>


                                    <hr>


                                    {{-- Short Description --}}
                                    @if ($prod->short_description)
                                        <p class="text-muted">

                                            {{ $prod->short_description }}

                                        </p>
                                    @endif


                                    {{-- Product Information --}}
                                    <div class="row mt-4">


                                        {{-- Category --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Category
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                {{ $prod->category->name ?? 'No Category' }}

                                            </p>

                                        </div>


                                        {{-- Availability --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Availability
                                            </strong>

                                            <div>

                                                @if ($prod->stock_status == 'in_stock')
                                                    <span class="badge bg-success">
                                                        In Stock
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        Out of Stock
                                                    </span>
                                                @endif

                                            </div>

                                        </div>


                                        {{-- SKU --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                SKU
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                {{ $prod->sku }}

                                            </p>

                                        </div>


                                        {{-- Barcode --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Barcode
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                {{ $prod->barcode ?? 'N/A' }}

                                            </p>

                                        </div>


                                        {{-- Quantity --}}
                                        <div class="col-md-6 mb-3">

                                            <strong>
                                                Quantity
                                            </strong>

                                            <p class="text-secondary mb-0">

                                                {{ $prod->quantity }}

                                            </p>

                                        </div>

                                    </div>


                                    <hr>


                                    {{-- Buttons --}}
                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="{{ url('admin/edit-product/' . $prod->id) }}" class="btn btn-warning">

                                            <i class="bi bi-pencil-square me-1"></i>

                                            Edit Product

                                        </a>


                                        <a href="{{ url('admin/view-product') }}" class="btn btn-secondary">

                                            <i class="bi bi-arrow-left me-1"></i>

                                            Back to Products

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Full Description --}}

                        <div class="p-4 p-lg-5 border-top">

                            <h3 class="fw-bold">
                                About Product
                            </h3>

                            <p class="text-muted mt-3">

                                {{ $prod->description }}

                            </p>

                        </div>


                    </div>

                </div>

            </section>

        </main>
    @endsection
