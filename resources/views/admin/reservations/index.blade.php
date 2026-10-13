@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4 mb-4" style="color: #4a5568; font-weight: 600;">Reservations</h1>
        
        <div class="card mb-4 shadow-sm border-0 rounded-lg">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-muted"><i class="bi bi-calendar-check me-1"></i> Active Reservations</h5>
                <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Add New Reservation
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-center align-middle">
                        <thead class="bg-light text-muted">
                            <tr>
                                <th>ID</th>
                                <th>Employee Name</th>
                                <th>Product Name</th>
                                <th>Reservation Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservations as $reservation)
                            <tr>
                                <td>#RES-{{ str_pad($reservation->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $reservation->user->name ?? 'Unknown' }}</td>
                                <td>{{ $reservation->product->name ?? 'Unknown Product' }}</td>
                                <td>{{ $reservation->created_at->format('Y-m-d h:i A') }}</td>
                                <td>
                                    @if($reservation->status == 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($reservation->status == 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-muted">No reservations found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
