@extends('admin.layouts.main')

@push('title')
    <title>Users</title>
@endpush

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div>
                        <h2 class="fw-bold mb-1"><i class="bi bi-people me-2 text-primary"></i>Users</h2>
                        <p class="text-muted mb-0">Manage all registered customers and their accounts.</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.users.export') }}" class="btn btn-outline-success me-2">
                            <i class="bi bi-file-earmark-excel me-2"></i>
                            Export Excel
                        </a>
                        <button type="button" class="btn btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus me-1"></i>
                            Add User
                        </button>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Total Users</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['total'] }}</div>
                                </div>
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3"><i
                                        class="bi bi-people-fill"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Active</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['active'] }}</div>
                                </div>
                                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3"><i
                                        class="bi bi-person-check"></i></div>
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
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3"><i
                                        class="bi bi-person-exclamation"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="text-muted small">Blocked</div>
                                    <div class="fw-bold fs-5 mt-2">{{ $stats['blocked'] }}</div>
                                </div>
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-3"><i
                                        class="bi bi-person-x"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">All Users</h5>
                    </div>
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th class="ps-4">User</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Joined</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    @if ($user->image)
                                                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                                             class="rounded-circle me-2"
                                                             style="width: 36px; height: 36px; object-fit: cover;">
                                                    @else
                                                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-2"
                                                             style="width: 36px; height: 36px; font-weight: 600;">
                                                            {{ mb_substr($user->name, 0, 2) }}
                                                        </div>
                                                    @endif
                                                    <div class="fw-semibold">{{ $user->name }}</div>
                                                </div>
                                            </td>
                                            <td class="text-muted small">{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? 'Not provided' }}</td>
                                            <td>{{ $user->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $statusClass = match ($user->status) {
                                                        'active' => 'success',
                                                        'pending' => 'warning',
                                                        'suspended', 'suspend' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} text-capitalize">{{ $user->status }}</span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <form action="{{ route('admin.users.status', $user) }}" method="POST"
                                                    class="d-inline-flex align-items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label class="visually-hidden"
                                                        for="user-status-{{ $user->id }}">Status</label>
                                                    <select id="user-status-{{ $user->id }}" name="status"
                                                        class="form-select form-select-sm rounded-3"
                                                        onchange="this.form.submit()">
                                                        <option value="active" @selected($user->status === 'active')>Active</option>
                                                        <option value="pending" @selected($user->status === 'pending')>Pending
                                                        </option>
                                                        <option value="suspend" @selected(in_array($user->status, ['suspend', 'suspended'], true))>Blocked
                                                        </option>
                                                    </select>
                                                </form>
                                                @if (in_array($user->status, ['suspend', 'suspended'], true))
                                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST"
                                                        class="d-inline ms-1"
                                                        onsubmit="return confirm('This will permanently delete this user. Are you sure?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No users found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white border-0">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus me-2"></i> Add New Employee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.employees.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Full Name</label>
                            <input type="text" class="form-control bg-light" id="name" name="name" required placeholder="e.g. John Doe">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email Address</label>
                            <input type="email" class="form-control bg-light" id="email" name="email" required placeholder="e.g. john@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Temporary Password</label>
                            <input type="text" class="form-control bg-light" id="password" name="password" required minlength="6" placeholder="Must be at least 6 characters">
                            <div class="form-text">Share these details with the employee so they can log in.</div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Create Employee Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
