@extends('user.layouts.main')

@section('title', $order ? 'Order #' . $order->order_number : 'Order Details')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-receipt me-2 text-primary"></i>
                Order Details
            </h1>
            <p class="text-muted mb-0">
                View and track the details of this order.
            </p>
        </div>

        <a href="{{ url('user/order-history') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-arrow-left me-1"></i>
            Back to Order History
        </a>
    </div>

    @if ($order)

        @php
            $status = strtolower($order->status ?? 'pending');

            $statusClass = match($status) {
                'delivered' => 'bg-success',
                'processing' => 'bg-warning text-dark',
                'shipped' => 'bg-info text-dark',
                'cancelled', 'canceled' => 'bg-danger',
                'pending' => 'bg-warning text-dark',
                default => 'bg-secondary',
            };
        @endphp

        {{-- Order Summary --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-0 px-4 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Order #{{ $order->order_number ?? $order->id }}</h5>
                    <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                        {{ $status }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Placed On</div>
                        <div class="fw-semibold">
                            {{ $order->placed_at?->format('M j, Y h:i A') ?? $order->created_at?->format('M j, Y h:i A') }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Payment Method</div>
                        <div class="fw-semibold text-capitalize">
                            {{ $order->payment_method ?? '—' }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Coupon</div>
                        <div class="fw-semibold">
                            {{ $order->coupon_code ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- Shipping + Totals --}}
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 px-4 py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-truck me-2"></i>Shipping Address</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-1 fw-semibold">
                            {{ $order->shipping_name ?: '—' }}
                            @if ($order->shipping_phone)
                                <span class="text-muted">({{ $order->shipping_phone }})</span>
                            @endif
                        </p>
                        <p class="text-muted mb-0">{{ $order->shipping_address ?: '—' }}</p>
                        @if ($order->shipping_method)
                            <p class="text-muted small mb-0 mt-2">
                                <i class="bi bi-box me-1"></i>{{ $order->shipping_method }}
                            </p>
                        @endif
                        @if ($order->notes)
                            <p class="text-muted small mb-0 mt-2"><strong>Notes:</strong> {{ $order->notes }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 px-4 py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-calculator me-2"></i>Order Summary</h6>
                    </div>
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Subtotal</span>
                            <span>$ {{ number_format((float) ($order->subtotal ?? 0), 2) }}</span>
                        </div>
                        @if ($order->discount_total && (float) $order->discount_total > 0)
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Discount</span>
                                <span class="text-success">- $ {{ number_format((float) $order->discount_total, 2) }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Shipping</span>
                            <span>$ {{ number_format((float) ($order->shipping_total ?? 0), 2) }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-0">
                            <span>Total</span>
                            <span>$ {{ number_format((float) ($order->total ?? 0), 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- Items --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 px-4 py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Items
                    ({{ $order->items?->count() ?? 0 }})</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Product</th>
                                <th class="py-3">Quantity</th>
                                <th class="py-3">Unit Price</th>
                                <th class="text-end px-4 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-4">
                                        <span class="fw-semibold text-dark">{{ $item->product_name }}</span>
                                        @if ($item->product_id)
                                            <a href="{{ url('product/' . $item->product_id) }}"
                                               class="small text-muted d-block">
                                                View product <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>$ {{ number_format((float) ($item->unit_price ?? 0), 2) }}</td>
                                    <td class="text-end fw-semibold">$ {{ number_format((float) ($item->subtotal ?? 0), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                </div>
            </div>
        </div>
@else
        {{-- No order selected --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5 px-4">
                <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
                     style="width: 90px; height: 90px;">
                    <i class="bi bi-receipt-cutoff text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Select an Order</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 450px;">
                    Choose an order from your order history to view its details.
                </p>
                <a href="{{ url('user/order-history') }}" class="btn btn-primary rounded-pill px-4 py-2">
                    <i class="bi bi-clock-history me-2"></i>
                    View Order History
                </a>
            </div>
        </div>
    @endif

</div>
@endsection