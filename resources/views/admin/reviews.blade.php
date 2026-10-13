@extends('admin.layouts.main')

@push('title')
    <title>Reviews - {{ config('app.name', 'E-Commerce') }}</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Reviews</h1>
                        <p class="text-muted">Moderate product reviews.</p>
                    </div>
                    @if (request('status'))
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">Clear Filter</a>
                    @endif
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Reviews</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['total'] }}</div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i class="bi bi-chat-left-text"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Approved</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['approved'] }}</div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i class="bi bi-patch-check"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Pending</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['pending'] }}</div>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i class="bi bi-hourglass-split"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Rejected</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['rejected'] }}</div>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3"><i class="bi bi-emoji-x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Review List</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reviews as $review)
                                        <tr>
                                            <td>{{ $review->product?->name ?? '-' }}</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($review->user?->image)
                                                        <img src="{{ asset('storage/' . $review->user->image) }}"
                                                             alt="{{ $review->user->name }}"
                                                             class="rounded-circle"
                                                             style="width: 32px; height: 32px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                             style="width: 32px; height: 32px; font-size: 0.75rem; font-weight: 600;">
                                                            {{ substr($review->user?->name ?? 'U', 0, 1) }}
                                                        </div>
                                                    @endif
                                                    {{ $review->user?->name ?? '-' }}
                                                </div>
                                            </td>
                                            <td>{{$review->rating}}/5</td>
                                            <td>{{ Str::limit($review->comment, 60) }}</td>
                                            <td>
                                                <form action="{{ route('admin.reviews.status', $review) }}" method="POST" class="d-flex align-items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                        <option value="approved" @selected($review->status === 'approved')>Approved</option>
                                                        <option value="pending" @selected($review->status === 'pending')>Pending</option>
                                                        <option value="rejected" @selected($review->status === 'rejected')>Rejected</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="text-end">
                                                {{ $review->created_at?->format('M d, Y') }}
                                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-2">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No reviews found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($reviews->hasPages())
                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </main>
    
@endsection
