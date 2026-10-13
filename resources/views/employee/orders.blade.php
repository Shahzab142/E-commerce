@extends('employee.layouts.main')

@push('title')
    <title>Orders - Employee Portal</title>
    <style>
        .search-box-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            margin-bottom: 24px;
        }
        .search-input-group {
            position: relative;
            margin-bottom: 12px;
        }
        .search-input-group .form-control {
            border-radius: 8px 0 0 8px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 16px;
            font-size: 0.95rem;
        }
        .search-input-group .btn-search {
            border-radius: 0 8px 8px 0;
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            padding: 0 20px;
        }
        .search-input-group .btn-search:hover {
            background-color: #0369a1;
        }
        .orders-table-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: capitalize;
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-navy" style="color: #1e3a8a;">Orders</h2>
            <p class="text-muted">Viewing status: <span class="badge bg-success text-uppercase">{{ str_replace('-', ' ', $currentStatus) }}</span></p>
        </div>

        <!-- 3 Search Bars matching the video -->
        <div class="search-box-card">
            <form action="{{ route('employee.orders', $currentStatus) }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="customer_email" class="form-control" placeholder="Search by customer email..." value="{{ request('customer_email') }}">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="product_id" class="form-control" placeholder="Search by product ID..." value="{{ request('product_id') }}">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group search-input-group mb-0">
                            <input type="text" name="order_number" class="form-control" placeholder="Search by order #..." value="{{ request('order_number') }}">
                            <button type="submit" class="btn btn-search"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Active Orders Table -->
        <div class="orders-table-card">
            <h5 class="fw-bold mb-4 text-dark">Active Orders</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Seller</th>
                            <th>User</th>
                            <th>Order Number</th>
                            <th>Product</th>
                            <th>Customer Email</th>
                            <th>Market</th>
                            <th>Type</th>
                            <th>Update Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="https://wa.me/923001234567" target="_blank" class="btn btn-sm btn-outline-success rounded-circle p-1" title="WhatsApp Seller">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            </td>
                            <td>{{ $order->user->name ?? 'Customer' }}</td>
                            <td class="fw-semibold text-primary">{{ $order->order_number }}</td>
                            <td>{{ $order->items->first()?->product_name ?? 'Product' }}</td>
                            <td>{{ $order->user->email ?? 'N/A' }}</td>
                            <td><span class="badge bg-light text-dark border">US</span></td>
                            <td>Text Review</td>
                            <td>{{ $order->updated_at->format('d M, Y') }}</td>
                            <td>
                                @php
                                    $badgeClass = match($order->status) {
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                        'refunded' => 'bg-warning text-dark',
                                        'on_hold' => 'bg-secondary',
                                        default => 'bg-info text-dark',
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} status-badge">{{ str_replace('_', ' ', $order->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-2 d-block mb-2 text-secondary"></i>
                                No orders found under this filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</main>
@endsection
