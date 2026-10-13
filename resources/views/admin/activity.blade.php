@extends('admin.layouts.main')

@push('title')
    <title>Activity Log - {{ config('app.name', 'E-Commerce') }}</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h2 fw-bold">Activity Log</h1>
                        <p class="text-muted">All system activity and audit trail.</p>
                    </div>
                    <form method="GET" action="{{ route('admin.activity') }}" class="d-flex gap-2">
                        <select name="actor" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                            <option value="">All Actors</option>
                            <option value="admin" {{ request('actor') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="employee" {{ request('actor') === 'employee' ? 'selected' : '' }}>Employee</option>
                            <option value="vendor" {{ request('actor') === 'vendor' ? 'selected' : '' }}>Vendor</option>
                        </select>
                    </form>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Logs</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['total'] }}</div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i class="bi bi-file-text"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Admin Actions</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['admin'] }}</div>
                                </div>
                                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3"><i class="bi bi-person-gear"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Employee Actions</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['employee'] ?? $stats['vendor'] ?? 0 }}</div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i class="bi bi-person-badge"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Today</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['today'] }}</div>
                                </div>
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i class="bi bi-today"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Recent Activity ({{ $logs->total() }})</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Actor</th>
                                        <th>Action</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($logs as $log)
                                        <tr>
                                            <td class="text-muted small">{{ $log->created_at?->format('M d, Y H:i') }}</td>
                                            <td>
                                                @if ($log->actor)
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                                            {{ mb_substr($log->actor->name ?? '?', 0, 2) }}
                                                        </div>
                                                        {{ $log->actor->name ?? '-' }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">System</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill bg-{{ $log->actor_type === 'vendor' ? 'warning' : 'primary' }}-subtle text-{{ $log->actor_type === 'vendor' ? 'warning' : 'primary' }}">
                                                    {{ ucfirst($log->actor_type ?? 'system') }}
                                                </span>
                                                <div class="small text-muted mt-1">{{ str_replace('.', ' ', $log->action ?? '-') }}</div>
                                            </td>
                                            <td>{{ $log->description ?? '-' }}</td>
                                            <td class="text-end">
                                                @if ($log->actor_type === 'vendor' && $log->subject_type === \App\Models\User::class && in_array($log->action, [\App\Models\ActivityLog::ACTION_USER_BLOCKED, \App\Models\ActivityLog::ACTION_USER_DELETED]))
                                                    <form action="{{ route('admin.vendor-actions.reverse', $log) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The user account will be restored/reactivated.');">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                @elseif ($log->actor_type === 'vendor' && $log->subject_type === \App\Models\Order::class && in_array($log->action, [\App\Models\ActivityLog::ACTION_ORDER_DELETED, \App\Models\ActivityLog::ACTION_ORDER_CANCELLED]))
                                                    <form action="{{ route('admin.vendor-actions.reverse', $log) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The order will be restored.');">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                @elseif ($log->actor_type === 'vendor' && $log->subject_type === \App\Models\AdminProduct::class && $log->action === \App\Models\ActivityLog::ACTION_PRODUCT_DELETED)
                                                    <form action="{{ route('admin.vendor-actions.reverse', $log) }}" method="POST"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Reverse this vendor action? The product will be restored.');">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3">
                                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reverse
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No activity logs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($logs->hasPages())
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @endif

                <form id="delete-log-form" method="POST" action="" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </main>
   
@endsection
