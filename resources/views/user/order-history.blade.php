@extends('user.layouts.main')

@section('title', 'Order History')

@section('content')
<div class="container-fluid px-4 py-4">

    @if (session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-clock-history me-2 text-primary"></i>
                Order History
            </h1>
            <p class="text-muted mb-0">
                View and track all your previous orders.
            </p>
        </div>

        <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill px-4">
            <i class="bi bi-cart3 me-1"></i>
            Continue Shopping
        </a>
    </div>

    {{-- Orders Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1">My Orders</h5>
                    <p class="text-muted small mb-0">
                        Your complete order history
                    </p>
                </div>

                <span class="badge bg-primary rounded-pill px-3 py-2">
                    {{ $orders->count() }} Orders
                </span>
            </div>
        </div>

        <div class="card-body p-0">

            @if($orders->count() > 0)

                {{-- Desktop / Tablet Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Order</th>
                                <th class="py-3">Date</th>
                                <th class="py-3">Items</th>
                                <th class="py-3">Total</th>
                                <th class="py-3">Status</th>
                                <th class="text-end px-4 py-3">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)

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

                                <tr>

                                    {{-- Order ID --}}
                                    <td class="px-4">
                                        <span class="fw-semibold text-dark">
                                            #{{ $order->id }}
                                        </span>
                                    </td>

                                    {{-- Date --}}
                                    <td>
                                        <div class="fw-medium">
                                            {{ $order->created_at?->format('d M Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $order->created_at?->format('h:i A') }}
                                        </small>
                                    </td>

                                    {{-- Items --}}
                                    <td>
                                        @php
                                            $itemsCount = $order->orderItems?->count()
                                                ?? $order->items?->count()
                                                ?? 0;
                                        @endphp

                                        <span class="text-muted">
                                            {{ $itemsCount }}
                                            {{ $itemsCount == 1 ? 'item' : 'items' }}
                                        </span>
                                    </td>

                                    {{-- Total --}}
                                    <td>
                                        <span class="fw-bold text-dark">
                                           $ {{ number_format($order->total ?? 0, 2) }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        <span class="badge {{ $statusClass }} rounded-pill px-3 py-2 text-capitalize">
                                            {{ $status }}
                                        </span>
                                    </td>

                                    {{-- Action --}}
                                    <td class="text-end px-4">
                                        <a href="{{ url('user/details/' . $order->id) }}"
                                           class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                            <i class="bi bi-eye me-1"></i>
                                            View
                                        </a>
                                    </td>

                                </tr>

                            @endforeach
                        </tbody>

                    </table>
                </div>

            @else

                {{-- Empty State --}}
                <div class="text-center py-5 px-4">

                    <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10"
                         style="width: 90px; height: 90px;">

                        <i class="bi bi-bag-x text-primary"
                           style="font-size: 2.5rem;"></i>

                    </div>

                    <h4 class="fw-bold text-dark mb-2">
                        No Orders Yet
                    </h4>

                    <p class="text-muted mb-4 mx-auto"
                       style="max-width: 450px;">
                        You haven't placed any orders yet. Explore our products
                        and place your first order.
                    </p>

                    <a href="{{ url('/') }}"
                       class="btn btn-primary rounded-pill px-4 py-2">
                        <i class="bi bi-shop me-2"></i>
                        Start Shopping
                    </a>

                </div>

            @endif

        </div>
    </div>

</div>
@endsection