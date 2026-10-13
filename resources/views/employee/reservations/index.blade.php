@extends('employee.layouts.main')

@push('title')
    <title>Reserved Orders - Employee Portal</title>
    <style>
        .res-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 24px;
        }
        .timer-badge {
            color: #ef4444;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
            font-family: monospace;
        }
        .img-thumb-res {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .btn-create-order {
            background-color: #0284c7;
            color: #ffffff;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
        }
        .btn-create-order:hover {
            background-color: #0369a1;
            color: #ffffff;
        }
        .btn-release {
            background-color: #be123c;
            color: #ffffff;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 6px;
        }
        .btn-release:hover {
            background-color: #9f1239;
            color: #ffffff;
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Reserved Orders</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="res-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0 text-dark">Active Reservations</h5>
                <a href="{{ route('employee.reservations.create') }}" class="btn btn-sm btn-success rounded-pill px-3">
                    <i class="bi bi-plus-circle me-1"></i> Add Reservation
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Product ID</th>
                            <th>Remaining Time</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $res)
                        @php
                            $img = $res->product?->images->first()?->image;
                            $imgUrl = $img ? asset('storage/' . $img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=200';
                            $targetTimestamp = $res->expires_at ? \Carbon\Carbon::parse($res->expires_at)->timestamp : now()->addHours(2)->timestamp;
                        @endphp
                        <tr>
                            <td class="text-muted">2206087{{ $res->id }}</td>
                            <td class="fw-semibold text-dark">{{ $res->user->name ?? 'Employee' }}</td>
                            <td class="fw-bold text-primary">#{{ $res->product_id }}</td>
                            <td>
                                <span class="timer-badge countdown-timer" data-expire="{{ $targetTimestamp }}">
                                    1:28:20
                                </span>
                            </td>
                            <td>
                                <img src="{{ $imgUrl }}" alt="Product" class="img-thumb-res">
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('employee.reservations.order.create', $res->id) }}" class="btn btn-create-order">
                                        <i class="bi bi-cart-plus me-1"></i> Create Order
                                    </a>

                                    <button type="button" class="btn btn-release" data-bs-toggle="modal" data-bs-target="#releaseModal{{ $res->id }}">
                                        <i class="bi bi-x me-1"></i> Release
                                    </button>
                                </div>

                                <!-- Confirm Delete Modal Matching Video -->
                                <div class="modal fade" id="releaseModal{{ $res->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                            <div class="modal-header bg-danger text-white py-2">
                                                <h6 class="modal-title fw-bold">Confirm Delete</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <h5 class="fw-bold text-dark mb-2">Warning !!!</h5>
                                                <p class="text-muted mb-0">Do you wish to proceed with Release?</p>
                                            </div>
                                            <div class="modal-footer justify-content-center border-0 pb-4">
                                                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">NO</button>
                                                <form action="{{ route('employee.reservations.release', $res->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger px-4 rounded-pill">YES</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
                                No active reservations found.
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

@push('script')
<script>
    // Live countdown timer script
    function updateTimers() {
        const timerEls = document.querySelectorAll('.countdown-timer');
        const now = Math.floor(Date.now() / 1000);

        timerEls.forEach(el => {
            const expire = parseInt(el.getAttribute('data-expire'), 10);
            let diff = expire - now;

            if (diff <= 0) {
                el.innerText = '0:00:00 (Expired)';
                el.classList.add('text-muted');
                return;
            }

            const hours = Math.floor(diff / 3600);
            const minutes = Math.floor((diff % 3600) / 60);
            const seconds = diff % 60;

            el.innerText = `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        });
    }

    setInterval(updateTimers, 1000);
    updateTimers();
</script>
@endpush
