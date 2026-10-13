@extends('admin.layouts.main')

<title>Add Product</title>

@push('title')
@endpush

@section('content')

    <div id="layoutSidenav_content">

        <main>

            <div class="container-fluid px-4 py-4">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif


                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">

                        <strong>Please fix the following errors:</strong>

                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    </div>
                @endif


                {{-- Header --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

                    <div>

                        <h2 class="fw-bold mb-1">
                            <i class="bi bi-box-seam me-2 text-primary"></i>
                            Add New Product
                        </h2>

                    </div>


                    <div class="mt-3 mt-md-0">
                        <a href="{{ route('admin.products.view') }}" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-eye me-1"></i>
                            Product List
                        </a>
                        <button type="submit" form="productForm" class="btn btn-primary">

                            <i class="bi bi-check-circle me-1"></i>
                            Publish

                        </button>

                    </div>

                </div>


                {{-- Product Form --}}
                <form method="POST" action="{{ url('admin/add-product') }}" enctype="multipart/form-data" id="productForm">

                    @csrf


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

                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" placeholder="Enter product name">

                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- SKU + Barcode --}}
                                    <div class="row">


                                        {{-- SKU --}}
                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                SKU
                                            </label>

                                            <input type="text" name="sku"
                                                class="form-control @error('sku') is-invalid @enderror"
                                                value="{{ old('sku') }}" placeholder="SKU">

                                            @error('sku')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>


                                        {{-- Barcode --}}
                                        <div class="col-md-6 mb-3">

                                            <label class="form-label fw-semibold">
                                                Barcode
                                            </label>

                                            <input type="text" name="barcode"
                                                class="form-control @error('barcode') is-invalid @enderror"
                                                value="{{ old('barcode') }}" placeholder="Barcode">

                                            @error('barcode')
                                                <div class="invalid-feedback">
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

                                        <textarea class="form-control @error('short_description') is-invalid @enderror" name="short_description" rows="3"
                                            placeholder="Write short description">{{ old('short_description') }}</textarea>

                                        @error('short_description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Full Description --}}
                                    <div>

                                        <label class="form-label fw-semibold">
                                            Full Description
                                        </label>

                                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="8"
                                            placeholder="Write detailed product description">{{ old('description') }}</textarea>

                                        @error('description')
                                            <div class="invalid-feedback">
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

                                    <input type="file" name="image[]"
                                        class="form-control @error('image') is-invalid @enderror" multiple
                                        accept="image/jpeg,image/png,image/jpg,image/webp">


                                    <div class="form-text">
                                        Upload multiple product images.
                                    </div>


                                    @error('image')
                                        <div class="text-danger mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror


                                    @error('image.*')
                                        <div class="text-danger mt-1">
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

                                        <input type="number" name="regular_price"
                                            class="form-control @error('regular_price') is-invalid @enderror"
                                            value="{{ old('regular_price') }}" min="0" step="0.01">

                                        @error('regular_price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Sale Price --}}
                                    <div>

                                        <label class="form-label">
                                            Sale Price
                                        </label>

                                        <input type="number" name="sale_price"
                                            class="form-control @error('sale_price') is-invalid @enderror"
                                            value="{{ old('sale_price') }}" min="0" step="0.01">

                                        @error('sale_price')
                                            <div class="invalid-feedback">
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

                                        <input type="number" name="quantity"
                                            class="form-control @error('quantity') is-invalid @enderror"
                                            value="{{ old('quantity') }}" min="0">

                                        @error('quantity')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>


                                    {{-- Stock Status --}}
                                    <div>

                                        <label class="form-label">
                                            Stock Status
                                        </label>

                                        <select name="stock_status"
                                            class="form-select @error('stock_status') is-invalid @enderror">

                                            <option value="in_stock"
                                                {{ old('stock_status', 'in_stock') == 'in_stock' ? 'selected' : '' }}>
                                                In Stock
                                            </option>

                                            <option value="out_of_stock"
                                                {{ old('stock_status') == 'out_of_stock' ? 'selected' : '' }}>
                                                Out of Stock
                                            </option>

                                        </select>

                                        @error('stock_status')
                                            <div class="invalid-feedback">
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

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Category
                                        </label>

                                        <select name="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror">

                                            <option value="">
                                                Select Category
                                            </option>


                                            @if ($categories->count() > 0)
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>

                                                        {{ $cat->name }}

                                                    </option>
                                                @endforeach
                                            @endif

                                        </select>


                                        @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- =====================================================
                                 PRODUCT COUPON
                            ====================================================== --}}

                            <div class="card shadow-sm border-0 mb-4">

                                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold mb-0">
                                        Product Coupon
                                    </h5>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="has_coupon" name="has_coupon" value="1" {{ old('has_coupon') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-muted" for="has_coupon">Enable coupon</label>
                                    </div>
                                </div>

                                <div class="card-body" id="coupon-fields" style="display: none;">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Coupon Code
                                        </label>
                                        <input type="text" name="coupon_code" class="form-control @error('coupon_code') is-invalid @enderror"
                                            value="{{ old('coupon_code') }}" placeholder="e.g. SAVE20">
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
                                                <option value="fixed" {{ old('coupon_type', 'fixed') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                                <option value="percent" {{ old('coupon_type') == 'percent' ? 'selected' : '' }}>Percentage</option>
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
                                                value="{{ old('coupon_value') }}" min="0" step="0.01">
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
                                                value="{{ old('coupon_min_order_amount', 0) }}" min="0" step="0.01">
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
                                                value="{{ old('coupon_max_discount_amount') }}" min="0" step="0.01">
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
                                                value="{{ old('coupon_usage_limit') }}" min="1" placeholder="Unlimited if empty">
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
                                                value="{{ old('coupon_expires_at') }}">
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


                                    <div class="mb-3">

                                        <label class="form-label">
                                            Product Status
                                        </label>


                                        <select name="status" class="form-select @error('status') is-invalid @enderror">


                                            <option value="draft"
                                                {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                                                Draft
                                            </option>


                                            <option value="published"
                                                {{ old('status') == 'published' ? 'selected' : '' }}>
                                                Published
                                            </option>


                                            <option value="hidden" {{ old('status') == 'hidden' ? 'selected' : '' }}>
                                                Pending
                                            </option>


                                        </select>


                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                    </div>



                                    {{-- Buttons --}}
                                    <div class="d-grid gap-2">

                                        <button type="submit" class="btn btn-primary">

                                            <i class="bi bi-cloud-upload me-2"></i>

                                            Add Publish

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
