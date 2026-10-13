@extends('admin.layouts.main')

@push('title')
    <title>Edit Product</title>
@endpush

@section('content')

    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

                    <div>
                        <h2 class="fw-bold mb-1">
                            <i class="bi bi-pencil-square me-2 text-primary"></i>
                            Edit Product
                        </h2>

                        <p class="text-muted mb-0">
                            Update the details below and save your changes.
                        </p>
                    </div>

                    <div class="mt-3 mt-md-0">

                        {{-- Preview Button --}}
                        <a href="{{ route('admin.products.show', $product->id) }}"target="_blank"
                            class="btn btn-outline-secondary me-2">

                            <i class="bi bi-eye me-1"></i>
                            Preview

                        </a>


                        {{-- Update Button --}}
                        <button type="submit" form="editProductForm" class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>
                            Update

                        </button>

                    </div>

                </div>


                {{-- Product Edit Form --}}
                <form id="editProductForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')


                    <div class="row g-4">


                        {{-- =====================================================
                            LEFT SIDE
                        ====================================================== --}}
                        <div class="col-lg-8">


                            {{-- Product Information --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Product Information
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- Product Name --}}
                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Product Name
                                        </label>

                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $product->name) }}">

                                        @error('name')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- SKU + Barcode --}}
                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                SKU
                                            </label>

                                            <input type="text" name="sku" class="form-control"
                                                value="{{ old('sku', $product->sku) }}">

                                            @error('sku')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Barcode
                                            </label>

                                            <input type="text" name="barcode" class="form-control"
                                                value="{{ old('barcode', $product->barcode) }}">

                                            @error('barcode')
                                                <div class="text-danger small mt-1">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>


                                    {{-- Short Description --}}
                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            Short Description
                                        </label>

                                        <textarea name="short_description" class="form-control" rows="3">{{ old('short_description', $product->short_description) }}</textarea>

                                        @error('short_description')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Full Description --}}
                                    <div>

                                        <label class="form-label fw-semibold">
                                            Full Description
                                        </label>

                                        <textarea name="description" class="form-control" rows="8">{{ old('description', $product->description) }}</textarea>

                                        @error('description')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- =====================================================
                                PRODUCT IMAGES
                            ====================================================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Product Images
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- Existing Images --}}
                                    <div class="d-flex flex-wrap gap-3 mb-3">

                                        @forelse($product->images as $image)
                                            <div class="position-relative">

                                                {{-- Product Image --}}
                                                <img src="{{ asset('storage/' . $image->image) }}" class="rounded border"
                                                    width="90" height="90" style="object-fit: cover;"
                                                    alt="Product image">


                                                {{-- Existing Image ID --}}
                                                <input type="hidden" name="existing_images[]" value="{{ $image->id }}">

                                            </div>

                                        @empty

                                            <div class="text-muted">
                                                No product images found.
                                            </div>
                                        @endforelse

                                    </div>


                                    {{-- Upload New Images --}}
                                    <input type="file" name="image[]" class="form-control"
                                        accept="image/jpeg,image/jpg,image/png,image/webp" multiple>


                                    <div class="form-text">
                                        If you upload new image then existing image automatically deleted .
                                    </div>


                                    @error('image')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    @error('image.*')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                            </div>



                        </div>



                        {{-- =====================================================
                            RIGHT SIDE
                        ====================================================== --}}
                        <div class="col-lg-4">


                            {{-- =====================================================
                                PRICING
                            ====================================================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Pricing
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- Regular Price --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Regular Price
                                        </label>

                                        <input type="number" name="regular_price" class="form-control" step="0.01"
                                            min="0" value="{{ old('regular_price', $product->regular_price) }}">

                                        @error('regular_price')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Sale Price --}}
                                    <div>

                                        <label class="form-label">
                                            Sale Price
                                        </label>

                                        <input type="number" name="sale_price" class="form-control" step="0.01"
                                            min="0" value="{{ old('sale_price', $product->sale_price) }}">

                                        @error('sale_price')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- =====================================================
                                INVENTORY
                            ====================================================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Inventory
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- Quantity --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Quantity
                                        </label>

                                        <input type="number" name="quantity" class="form-control" min="0"
                                            value="{{ old('quantity', $product->quantity) }}">

                                        @error('quantity')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Stock Status --}}
                                    <div>

                                        <label class="form-label">
                                            Stock Status
                                        </label>

                                        <select name="stock_status" class="form-select">

                                            <option value="in_stock"
                                                {{ old('stock_status', $product->stock_status) == 'in_stock' ? 'selected' : '' }}>
                                                In Stock
                                            </option>

                                            <option value="out_of_stock"
                                                {{ old('stock_status', $product->stock_status) == 'out_of_stock' ? 'selected' : '' }}>
                                                Out of Stock
                                            </option>

                                        </select>

                                        @error('stock_status')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- =====================================================
                                CATEGORY
                            ====================================================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Category
                                    </h5>

                                </div>


                                <div class="card-body">

                                    <div>

                                        <label class="form-label">
                                            Category
                                        </label>

                                        <select name="category_id" class="form-select">

                                            @if (isset($categories))
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>

                                                        {{ $category->name }}

                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="{{ $product->category_id }}">
                                                    {{ $product->category->name ?? 'Select Category' }}
                                                </option>
                                            @endif

                                        </select>

                                        @error('category_id')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>



                            {{-- =====================================================
                                STATUS / PUBLISH
                            ====================================================== --}}
                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">
                                        Product Coupon
                                    </h5>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="has_coupon" name="has_coupon" value="1" {{ old('has_coupon', $product->coupon && $product->coupon->is_active ? 'checked' : '') }}>
                                        <label class="form-check-label small text-muted" for="has_coupon">Enable coupon</label>
                                    </div>
                                </div>

                                <div class="card-body" id="coupon-fields" style="display: none;">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Coupon Code
                                        </label>
                                        <input type="text" name="coupon_code" class="form-control @error('coupon_code') is-invalid @enderror"
                                            value="{{ old('coupon_code', $product->coupon?->code) }}" placeholder="e.g. SAVE20">
                                        @error('coupon_code')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Discount Type
                                            </label>
                                            <select name="coupon_type" class="form-select @error('coupon_type') is-invalid @enderror">
                                                <option value="fixed" {{ old('coupon_type', $product->coupon?->type ?? 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                <option value="percent" {{ old('coupon_type', $product->coupon?->type ?? 'fixed') == 'percent' ? 'selected' : '' }}>Percentage</option>
                                            </select>
                                            @error('coupon_type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Discount Value
                                            </label>
                                            <input type="number" name="coupon_value" class="form-control @error('coupon_value') is-invalid @enderror"
                                                value="{{ old('coupon_value', $product->coupon?->value) }}" min="0" step="0.01">
                                            @error('coupon_value')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Min Order Amount
                                            </label>
                                            <input type="number" name="coupon_min_order_amount" class="form-control @error('coupon_min_order_amount') is-invalid @enderror"
                                                value="{{ old('coupon_min_order_amount', $product->coupon?->min_order_amount ?? 0) }}" min="0" step="0.01">
                                            @error('coupon_min_order_amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Max Discount Amount
                                            </label>
                                            <input type="number" name="coupon_max_discount_amount" class="form-control @error('coupon_max_discount_amount') is-invalid @enderror"
                                                value="{{ old('coupon_max_discount_amount', $product->coupon?->max_discount_amount) }}" min="0" step="0.01">
                                            @error('coupon_max_discount_amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Usage Limit
                                            </label>
                                            <input type="number" name="coupon_usage_limit" class="form-control @error('coupon_usage_limit') is-invalid @enderror"
                                                value="{{ old('coupon_usage_limit', $product->coupon?->usage_limit) }}" min="1" placeholder="Unlimited if empty">
                                            @error('coupon_usage_limit')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">
                                                Expires At
                                            </label>
                                            <input type="datetime-local" name="coupon_expires_at" class="form-control @error('coupon_expires_at') is-invalid @enderror"
                                                value="{{ old('coupon_expires_at', $product->coupon?->expires_at ? $product->coupon->expires_at->format('Y-m-d\TH:i') : '') }}">
                                            @error('coupon_expires_at')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                            </div>


                            {{-- =====================================================
                                STATUS / PUBLISH
                            ====================================================== --}}
                            <div class="card shadow-sm border-0">

                                <div class="card-header bg-white">

                                    <h5 class="fw-bold mb-0">
                                        Publish
                                    </h5>

                                </div>


                                <div class="card-body">


                                    {{-- Product Status --}}
                                    <div class="mb-3">

                                        <label class="form-label">
                                            Product Status
                                        </label>

                                        <select name="status" class="form-select">

                                            <option value="draft"
                                                {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>
                                                Draft
                                            </option>

                                            <option value="published"
                                                {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>
                                                Published
                                            </option>

                                            <option value="hidden"
                                                {{ old('status', $product->status) == 'hidden' ? 'selected' : '' }}>
                                                Hidden
                                            </option>

                                        </select>

                                        @error('status')
                                            <div class="text-danger small mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Buttons --}}
                                    <div class="d-grid gap-2">

                                        <button type="submit" class="btn btn-primary">

                                            <i class="bi bi-cloud-upload me-2"></i>
                                            Update Product

                                        </button>


                                        <button type="reset" class="btn btn-outline-secondary">

                                            Reset

                                        </button>

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                </form>

            </div>

        </main>



        <script>
        document.getElementById('has_coupon').addEventListener('change', function () {
            document.getElementById('coupon-fields').style.display = this.checked ? 'block' : 'none';
        });
        if (document.getElementById('has_coupon').checked) {
            document.getElementById('coupon-fields').style.display = 'block';
        }
    </script>

@endsection
