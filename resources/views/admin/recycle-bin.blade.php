@extends('admin.layouts.main')

@push('title')
    <title>Recycle Bin - {{ config('app.name', 'E-Commerce') }}</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Recycle Bin</h1>
                        <p class="text-muted">Deleted orders and accounts. Restore or permanently delete.</p>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($vendorActions > 0)
                    <div class="alert alert-warning">
                        You performed {{ $vendorActions }} moderation action(s).
                    </div>
                @endif

                @if ($orders->isNotEmpty())
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold mb-0">Deleted Orders ({{ count($orders) }})</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Deleted By</th>
                                            <th>Deleted At</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->user?->name ?? '-' }}</td>
                                                <td>${{ number_format((float) $order->total, 2) }}</td>
                                                <td>{{ $order->deletedBy?->name ?? 'Unknown' }}</td>
                                                <td>{{ $order->deleted_at?->format('M d, Y') }}</td>
                                                <td class="text-end">
                                                    <form action="{{ route('admin.orders.restore', $order->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                                    </form>
                                                    <form action="{{ route('admin.orders.force-delete', $order->id) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Permanently delete this order? This cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($users->isNotEmpty())
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="fw-bold mb-0">Deleted Accounts ({{ count($users) }})</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Account</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Deleted By</th>
                                            <th>Deleted At</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-capitalize">{{ $user->role }}</td>
                                                <td>{{ $user->deletedBy?->name ?? 'Unknown' }}</td>
                                                <td>{{ $user->deleted_at?->format('M d, Y') }}</td>
                                                <td class="text-end">
                                                    <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success"><i class="bi bi-arrow-counterclockwise"></i> Restore</button>
                                                    </form>
                                                    <form action="{{ route('admin.users.force-delete', $user->id) }}" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Permanently delete this account? This cannot be undone.')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($orders->isEmpty() && $users->isEmpty())
                    <div class="alert alert-info">
                        The recycle bin is empty.
                    </div>
                @endif
            </div>
        </main>
    
@endsection
