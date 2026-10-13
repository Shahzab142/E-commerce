@extends('layouts.main')

@push('title')
    <title>Track Order - {{ config('app.name', 'Shop Hub') }}</title>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Order Tracking</span>
                <h1 class="display-5 fw-bold mb-3">Track Your Order</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Enter your order ID or tracking number to see the current status of your shipment.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow rounded-4">
                    <div class="card-body p-5">
                        <form method="GET" action="{{ route('track.order.submit') }}">
                            <div class="mb-3">
                                <label for="tracking_number" class="form-label fw-semibold">Tracking / Order Number</label>
                                <input type="text" class="form-control form-control-lg" id="tracking_number" name="tracking_number" value="{{ $trackingNumber ?? '' }}" placeholder="e.g. ORD-12345" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                    <i class="bi bi-search me-2"></i>Track Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($trackingNumber && isset($steps) && $steps)
            <div class="row justify-content-center mt-5">
                <div class="col-lg-8">
                    @if ($order)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-5">
                                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                    <div>
                                        <h4 class="fw-bold mb-1">Order #{{ $order->order_number }}</h4>
                                        <p class="text-muted small mb-0">Placed on {{ $order->placed_at?->format('d M, Y') ?? $order->created_at->format('d M, Y') }}</p>
                                    </div>
                                    <span class="badge rounded-pill px-3 py-2 bg-{{ match($order->status) {
                                        'delivered' => 'success',
                                        'shipped' => 'info',
                                        'processing' => 'warning text-dark',
                                        'cancelled' => 'danger',
                                        default => 'secondary',
                                    } }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>

                                <div class="row g-3 text-sm">
                                    <div class="col-md-6">
                                        <span class="text-muted">Payment Method</span>
                                        <div class="fw-semibold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <span class="text-muted">Total</span>
                                        <div class="fw-semibold">${{ number_format((float) $order->total, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <h4 class="fw-bold mb-4">Tracking Result for: <span class="text-primary">{{ $trackingNumber }}</span></h4>
                            <div class="tracking-steps">
                                @foreach ($steps as $step)
                                    <div class="tracking-step d-flex gap-3 mb-4">
                                        <div class="tracking-icon">
                                            @if ($step['status'] === 'completed')
                                                <div class="icon-circle bg-success text-white"><i class="bi bi-check-lg"></i></div>
                                            @elseif ($step['status'] === 'active')
                                                <div class="icon-circle bg-primary text-white"><i class="bi bi-truck"></i></div>
                                            @else
                                                <div class="icon-circle bg-light text-muted"><i class="bi bi-circle"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-bold mb-0">{{ $step['label'] }}</h6>
                                            <small class="text-muted">{{ $step['date'] ?: 'Pending' }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($trackingNumber !== '' && (!$steps || !$order))
            <div class="row justify-content-center mt-5">
                <div class="col-lg-6">
                    <div class="alert alert-warning rounded-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        No order found for tracking number <strong>{{ $trackingNumber }}</strong>. Please check and try again.
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .tracking-steps { position: relative; }
        .tracking-step { position: relative; }
        .tracking-icon .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }
        .tracking-step:not(:last-child)::before { content: ""; position: absolute; left: 20px; top: 40px; bottom: -8px; width: 2px; background: #dee2e6; }
        .tracking-step:last-child::before { display: none; }
    </style>
@endpush
