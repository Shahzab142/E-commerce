@extends('layouts.main')

@push('title')
    <title>Shopping Cart</title>
@endpush

@section('content')
    <section class="py-5 bg-light">
        <div class="container">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                <div>
                    <h2 class="fw-bold mb-1">
                        <i class="bi bi-cart3 text-warning me-2"></i>Shopping Cart
                    </h2>
                </div>
                <a href="{{ url('/') }}" class="btn btn-outline-dark rounded-pill">
                    <i class="bi bi-arrow-left"></i>
                    Continue Shopping
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            @if ($items->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-cart-x display-4 text-muted"></i>
                        <h2 class="h4 mt-3">Your cart is empty</h2>
                        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">Browse Products</a>
                    </div>
                </div>
            @else
                <div class="row g-4">

                    {{-- Cart Items --}}
                    <div class="col-lg-8">
                        <div class="card border-0 shadow rounded-4">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="45%">Product</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Subtotal</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            @php
                                                $product = $item['product'];
                                                $image = $product->images->first();
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $image ? asset('storage/' . $image->image) : asset('assets/images/products/7.jpg') }}"
                                                            class="cart-img me-3" alt="{{ $product->name }}">
                                                        <div>
                                                            <a href="{{ url('category/electronics/tv/' . $product->id) }}" class="text-decoration-none text-dark">
                                                                <h6 class="fw-bold mb-1">{{ $product->name }}</h6>
                                                            </a>
                                                            <span class="badge bg-success mt-1">In Stock</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-center">
                                                    <h6 class="fw-bold text-danger mb-0">
                                                        ${{ number_format((float) ($product->sale_price ?? $product->regular_price), 2) }}
                                                    </h6>
                                                </td>

                                                <td>
                                                    <form action="{{ route('cart.update', $product) }}" method="POST"
                                                        class="input-group quantity-box mx-auto" style="max-width: 140px;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <label for="quantity-{{ $product->id }}" class="visually-hidden">Quantity</label>
                                                        <input id="quantity-{{ $product->id }}" type="number" name="quantity" min="1"
                                                            max="{{ $product->quantity }}" value="{{ $item['quantity'] }}"
                                                            class="form-control text-center" onchange="this.form.submit()">
                                                        <button class="btn btn-outline-secondary" type="submit" title="Update quantity">
                                                            <i class="bi bi-arrow-repeat"></i>
                                                        </button>
                                                    </form>
                                                </td>

                                                <td class="text-center">
                                                    <h5 class="fw-bold text-success mb-0">
                                                        ${{ number_format($item['subtotal'], 2) }}
                                                    </h5>
                                                </td>

                                                <td class="text-center">
                                                    <form action="{{ route('cart.remove', $product) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-outline-danger rounded-circle" type="submit" title="Remove item">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    {{-- Order Summary --}}
                    <div class="col-lg-4">

                        <div class="card border-0 shadow rounded-4 sticky-top" style="top:100px;">

                            <div class="card-body p-4">

                                <h4 class="fw-bold mb-4">
                                    <i class="bi bi-receipt-cutoff text-warning me-2"></i>Order Summary
                                </h4>

                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-muted">Subtotal</span>
                                    <strong>${{ number_format($subtotal, 2) }}</strong>
                                </div>

                                @if ($coupon)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">
                                            Discount
                                            <span class="badge bg-light text-dark border ms-1">{{ $coupon->code }}</span>
                                        </span>
                                        <strong class="text-danger">-${{ number_format($discount, 2) }}</strong>
                                    </div>
                                @endif

                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <h5 class="fw-bold mb-0">Total</h5>
                                        <small class="text-muted">Shipping calculated at checkout</small>
                                    </div>

                                    <h3 class="fw-bold text-danger mb-0">
                                        ${{ number_format($total, 2) }}
                                    </h3>
                                </div>

                                {{-- Coupon --}}
                                <label class="form-label fw-semibold">Coupon Code</label>

                                @if ($coupon)
                                    <div class="d-flex align-items-center justify-content-between border rounded-3 p-2 mb-4">
                                        <span class="fw-semibold"><i class="bi bi-tag-fill text-warning me-1"></i>{{ $coupon->code }}</span>
                                        <form action="{{ route('cart.coupon.remove', 'products') }}" method="POST" class="mb-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Remove</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{ route('cart.coupon.apply', 'products') }}" method="POST" class="input-group mb-4">
                                        @csrf
                                        <input type="text" name="code" class="form-control" placeholder="Enter coupon" required>
                                        <button class="btn btn-warning" type="submit">Apply</button>
                                    </form>
                                @endif

                                <a href="{{ route('checkout.form', 'products') }}">
                                    <button class="btn btn-warning w-100 py-3 fw-bold rounded-3 mb-3">
                                        <i class="bi bi-credit-card me-2"></i>
                                        Proceed to Checkout
                                    </button>
                                </a>

                                <a href="{{ url('/') }}" class="btn btn-outline-dark w-100 rounded-3">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Continue Shopping
                                </a>
                            </div>

                        </div>

                    </div>

                </div>
            @endif

        </div>
    </section>
@endsection