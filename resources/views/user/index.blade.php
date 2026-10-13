@extends('user.layouts.main')

@section('title', 'Dashboard')

@section('content')

<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding-top: 30px;
        padding-bottom: 50px;
    }

    .dashboard-eyebrow {
        text-align: center;
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .dashboard-title {
        text-align: center;
        color: #2d3748;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: #ffffff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        margin-bottom: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.06);
    }

    .stat-card-body {
        padding: 30px 20px;
        text-align: center;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 15px;
        display: block;
    }

    .stat-value {
        color: #2d3748;
        font-size: 2.8rem;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 10px;
    }

    .stat-trend {
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    .trend-up {
        color: #28a745;
    }
    
    .trend-down {
        color: #dc3545;
    }

    .trend-neutral {
        color: #6c757d;
    }

    .card-header-clean {
        background: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        padding: 15px 20px;
        font-weight: 600;
        color: #495057;
        border-radius: 8px 8px 0 0;
    }
</style>

<div class="dashboard-container px-3">
    
    <div class="dashboard-eyebrow">DASHBOARD</div>
    <h1 class="dashboard-title">Orders Overview</h1>

    @if(isset($userMessage) && $userMessage->is_active && !empty($userMessage->message))
    <div class="alert alert-info shadow-sm mb-4 text-center" style="border-radius: 8px; border: none; background-color: #e0f2fe; color: #0369a1;">
        <strong>Notice:</strong> {{ $userMessage->message }}
    </div>
    @endif

    <div class="row g-4">
        {{-- Completed / Paid --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="stat-card h-100">
                <div class="stat-card-body">
                    <span class="stat-label">COMPLETED</span>
                    <div class="stat-value">{{ $stats['deliveredOrders'] ?? 0 }}</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-caret-up-fill"></i> 0%
                    </div>
                </div>
            </div>
        </div>

        {{-- Cancelled --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="stat-card h-100">
                <div class="stat-card-body">
                    <span class="stat-label">CANCELLED</span>
                    <div class="stat-value">0</div>
                    <div class="stat-trend trend-down">
                        <i class="bi bi-caret-down-fill"></i> 0%
                    </div>
                </div>
            </div>
        </div>

        {{-- Refunded --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="stat-card h-100">
                <div class="stat-card-body">
                    <span class="stat-label">REFUNDED</span>
                    <div class="stat-value">0</div>
                    <div class="stat-trend trend-down">
                        <i class="bi bi-caret-down-fill"></i> 0%
                    </div>
                </div>
            </div>
        </div>

        {{-- Commissioned --}}
        <div class="col-12 col-md-6 col-lg-4 offset-lg-2">
            <div class="stat-card h-100">
                <div class="stat-card-body">
                    <span class="stat-label">COMMISSIONED</span>
                    <div class="stat-value">0</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-caret-up-fill"></i> 0%
                    </div>
                </div>
            </div>
        </div>

        {{-- Ordered / Total Reservations --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="stat-card h-100">
                <div class="stat-card-body">
                    <span class="stat-label">ORDERED</span>
                    <div class="stat-value">{{ $stats['totalOrders'] ?? 0 }}</div>
                    <div class="stat-trend trend-up">
                        <i class="bi bi-caret-up-fill"></i> 0%
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Table Box like the video --}}
    <div class="stat-card mt-5">
        <div class="card-header-clean">
            Recent Reservations
        </div>
        <div class="p-3 table-responsive">
            <table class="table table-borderless text-center align-middle mb-0" style="font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 2px solid #f4f6f9; color: #6c757d;">
                        <th class="py-3">Reservation ID</th>
                        <th class="py-3">Product</th>
                        <th class="py-3">Date</th>
                        <th class="py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        @php
                            $statusClass = match(strtolower($reservation->status ?? '')) {
                                'approved' => 'text-success',
                                'completed' => 'text-primary',
                                'rejected' => 'text-danger',
                                'pending' => 'text-warning',
                                default => 'text-secondary',
                            };
                        @endphp
                        <tr style="border-bottom: 1px solid #f4f6f9;">
                            <td class="py-3">#RES-{{ $reservation->id }}</td>
                            <td class="py-3 font-weight-bold">{{ $reservation->product ? $reservation->product->name : 'N/A' }}</td>
                            <td class="py-3 text-muted">{{ \Carbon\Carbon::parse($reservation->created_at)->format('d M, Y') }}</td>
                            <td class="py-3 font-weight-bold {{ $statusClass }}">{{ ucfirst($reservation->status) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-5 text-muted">No reservations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection