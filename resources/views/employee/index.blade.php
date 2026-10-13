@extends('employee.layouts.main')

@push('title')
    <title>Employee Dashboard - Khyber Pro</title>
    <style>
        .metric-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eef2f6;
            padding: 18px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 120px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
            transition: all 0.25s ease;
            text-decoration: none;
            color: inherit;
            height: 100%;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
            color: inherit;
        }
        .metric-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .metric-content {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .metric-number {
            font-size: 1.6rem;
            font-weight: 800;
            line-height: 1.1;
            color: #004b49;
            margin-bottom: 3px;
            letter-spacing: -0.5px;
        }
        .metric-title {
            font-size: 0.82rem;
            font-weight: 600;
            color: #4b5563;
            line-height: 1.25;
            margin-bottom: 2px;
            word-wrap: break-word;
        }
        .metric-sub {
            font-size: 0.72rem;
            color: #9ca3af;
            line-height: 1.2;
            transition: color 0.2s;
        }
        .metric-card:hover .metric-sub {
            color: #004b49;
        }
        .dashboard-header {
            text-align: center;
            padding: 6px 0 22px;
        }
        .dashboard-header h6 {
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .dashboard-header h2 {
            font-weight: 800;
            color: #1e3a8a;
            font-size: 1.85rem;
            letter-spacing: -0.5px;
        }
        .card-custom {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #eef2f6;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="dashboard-header">
            <h6>DASHBOARD</h6>
            <h2>Orders Overview</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-shield-slash-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- 10 Stat Cards Matching Client's Reference Design (5 per row on desktop) -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3 mb-4">
            @php
                $cards = [
                    [
                        'title' => 'Completed',
                        'val' => number_format($stats['completed']),
                        'bg' => '#14532d', // Forest Dark Green (Institutes style)
                        'icon' => 'bi-building',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'completed'),
                    ],
                    [
                        'title' => 'Total Orders',
                        'val' => number_format($stats['ordered']),
                        'bg' => '#346548', // Sage / Olive Green (Total Systems style)
                        'icon' => 'bi-display',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'ordered'),
                    ],
                    [
                        'title' => 'Reviewed',
                        'val' => number_format($stats['reviewed']),
                        'bg' => '#0b6b7b', // Ocean Teal (Connected style)
                        'icon' => 'bi-wifi',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'reviewed'),
                    ],
                    [
                        'title' => 'Commissioned',
                        'val' => number_format($stats['commissioned']),
                        'bg' => '#199d4b', // Vibrant Emerald (Active style)
                        'icon' => 'bi-activity',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'commissioned'),
                    ],
                    [
                        'title' => 'On Hold',
                        'val' => number_format($stats['on_hold']),
                        'bg' => '#c27803', // Ochre / Warm Amber (Idle style)
                        'icon' => 'bi-clock',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'on-hold'),
                    ],
                    [
                        'title' => 'Refunded',
                        'val' => number_format($stats['refunded']),
                        'bg' => '#c91c22', // Crimson Red (Offline style)
                        'icon' => 'bi-slash-circle',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'refunded'),
                    ],
                    [
                        'title' => 'Cancelled',
                        'val' => number_format($stats['cancelled']),
                        'bg' => '#991b1b', // Deep Red
                        'icon' => 'bi-x-circle',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'cancelled'),
                    ],
                    [
                        'title' => 'Refund Pending',
                        'val' => number_format($stats['refunded_pending_review']),
                        'bg' => '#3b49df', // Indigo
                        'icon' => 'bi-arrow-repeat',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'refunded-pending-review'),
                    ],
                    [
                        'title' => 'Review Submitted',
                        'val' => number_format($stats['review_submitted_refund']),
                        'bg' => '#0284c7', // Sky Blue
                        'icon' => 'bi-hand-thumbs-up',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'review-submitted-refund'),
                    ],
                    [
                        'title' => 'Review Deleted',
                        'val' => number_format($stats['review_deleted']),
                        'bg' => '#64748b', // Slate Gray
                        'icon' => 'bi-trash3',
                        'sub' => 'View details →',
                        'route' => route('employee.orders', 'review-deleted'),
                    ],
                ];
            @endphp

            @foreach($cards as $card)
            <div class="col">
                <a href="{{ $card['route'] }}" class="metric-card">
                    <div class="metric-icon-box" style="background-color: {{ $card['bg'] }};">
                        <i class="bi {{ $card['icon'] }} text-white fs-5"></i>
                    </div>
                    <div class="metric-content">
                        <div class="metric-number">{{ $card['val'] }}</div>
                        <div class="metric-title">{{ $card['title'] }}</div>
                        <div class="metric-sub">{{ $card['sub'] }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- 2 Overview Sections as shown in video: Completed Orders & Order By Status -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Completed Orders</h5>
                        <a href="{{ route('employee.orders', 'completed') }}" class="btn btn-sm btn-outline-success rounded-pill px-3">View All</a>
                    </div>
                    @if($completedOrders->isEmpty())
                        <div class="p-4 text-center text-muted bg-light rounded-3">
                            <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                            No completed orders found.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedOrders as $order)
                                    <tr>
                                        <td class="fw-semibold text-primary">{{ $order->order_number }}</td>
                                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td class="text-muted">{{ $order->created_at->format('d M, Y') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Order By Status</h5>
                    </div>
                    <div class="row g-2">
                        @foreach($ordersByStatus as $stName => $stCount)
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                <span class="fw-medium text-secondary">{{ $stName }}</span>
                                <span class="badge bg-success rounded-pill px-3 py-2 fs-6">{{ $stCount }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
