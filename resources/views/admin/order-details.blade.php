@extends('admin.layouts.main')

@push('title')
    <title>
        Order Details</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                @if ($order)
                    <h1 class="h2 fw-bold">Order {{ $order->order_number }}</h1>
                    <p class="text-muted">Customer: {{ $order->user?->name }} ({{ $order->user?->email }})</p>
                    <div class="card mb-4">
                        <div class="card-body">
                            <p class="mb-1"><strong>Status:</strong> <span
                                    class="text-capitalize">{{ $order->status }}</span></p>
                            <p class="mb-1"><strong>Payment:</strong> {{ $order->payment_method }}</p>
                            <p class="mb-1"><strong>Shipping:</strong> {{ $order->shipping_address }}</p>
                            <p class="mb-0"><strong>Total:</strong> ${{ number_format((float) $order->total, 2) }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>${{ number_format((float) $item->unit_price, 2) }}</td>
                                            <td>${{ number_format((float) $item->subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info">Select an order to view its details.</div>
                @endif
            </div>
        </main>
    
@endsection
