@extends('admin.layouts.main')

@push('title')
    <title>Customer Profile - {{ $customer->name }}</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Customer Profile</h1>
                        <p class="text-muted">{{ $customer->name }} - {{ $customer->email }}</p>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to Users
                    </a>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Orders</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['totalOrders'] }}</div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i class="bi bi-box-seam"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Spent</div>
                                    <div class="fw-bold fs-5 mt-2">${{ number_format((float) $stats['totalSpent'], 2) }}</div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i class="bi bi-currency-dollar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Avg Order Value</div>
                                    <div class="fw-bold fs-5 mt-2">${{ number_format((float) $stats['avgOrderValue'], 2) }}</div>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3"><i class="bi bi-graphbar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Pending Orders</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['pendingOrders'] }}</div>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i class="bi bi-hourglass-split"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Order History ({{ $stats['totalOrders'] }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ ($order->placed_at ?? $order->created_at)?->format('M d, Y') }}</td>
                                            <td>${{ number_format((float) $order->total, 2) }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match (strtolower($order->status)) {
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'shipped' => 'primary',
                                                        'delivered' => 'success',
                                                        'cancelled' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} text-capitalize">{{ $order->status }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No orders found for this customer.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
   
@endsection
