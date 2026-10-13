@extends('employee.layouts.main')

@push('title')
    <title>Delay Refund - Employee Portal</title>
    <style>
        .delay-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Delay Refund</h2>
            <p class="text-muted">Total Pending Refund Orders = ( <strong class="text-primary">{{ $delayedOrders->count() }}</strong> )</p>
        </div>

        <div class="delay-card">
            <h5 class="fw-bold mb-4 text-dark">Sellers / Pending Refund Orders</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Product ID</th>
                            <th>Order Number</th>
                            <th>Order Creation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($delayedOrders as $order)
                        <tr>
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $order->user->name ?? 'Customer' }}</td>
                            <td class="fw-bold text-primary">#{{ $order->items->first()?->product_id ?? 'N/A' }}</td>
                            <td class="fw-semibold text-secondary">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    {{ str_replace('_', ' ', $order->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-clock-history fs-2 d-block mb-2 text-secondary"></i>
                                No delayed refund orders found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
