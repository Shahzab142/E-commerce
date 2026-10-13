@extends('admin.layouts.main')

@push('title')
    <title>Orders Management - Admin</title>
    <style>
        .page-container {
            background-color: #f3f4f6;
            min-height: 100vh;
            padding-bottom: 2rem;
        }
        .page-title {
            text-align: center;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 2rem;
            margin: 1.5rem 0 2rem;
        }
        .search-container {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            display: flex;
            margin-bottom: 1.5rem;
            overflow: hidden;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .search-input {
            border: none;
            padding: 1rem 1.25rem;
            flex-grow: 1;
            background-color: #f9fafb;
            color: #4b5563;
            outline: none;
        }
        .search-input::placeholder {
            color: #9ca3af;
        }
        .search-btn {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 0 1.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-btn:hover {
            background-color: #2563eb;
        }
        .orders-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            max-width: 800px;
            margin: 2rem auto 0;
            overflow: hidden;
        }
        .orders-card-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            color: #1e3a8a;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        .custom-table th {
            padding: 1rem 1.5rem;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid #e5e7eb;
            white-space: nowrap;
        }
        .custom-table td {
            padding: 1rem 1.5rem;
            color: #4b5563;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.9rem;
        }
        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>
@endpush

@section('content')
    <div id="layoutSidenav_content" class="page-container">
        <main>
            <div class="container-fluid px-4 pt-4">
                <h1 class="page-title">Orders</h1>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search by customer email...">
                    <button class="search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search by product ID...">
                    <button class="search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>

                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search by order #">
                    <button class="search-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </button>
                </div>

                <div class="orders-card">
                    <div class="orders-card-header">
                        Active Orders
                    </div>
                    <div style="overflow-x: auto;">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Seller</th>
                                    <th>User</th>
                                    <th>Order Number</th>
                                    <th>Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders->take(10) as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>Admin</td>
                                        <td>{{ $order->user?->name ?? 'Guest' }}</td>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->items->first()?->product?->name ?? ($order->items->sum('quantity') . ' Items') }}</td>
                                    </tr>
                                @endforeach
                                @if($orders->isEmpty())
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 2rem;">No active orders found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
