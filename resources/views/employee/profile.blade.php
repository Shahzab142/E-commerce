@extends('employee.layouts.main')

@push('title')
    <title>User Profile - Employee Portal</title>
@endpush

@push('style')
    <style>
        .profile-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 650px;
            margin: 0 auto;
        }
        .profile-avatar-wrapper {
            text-align: center;
            margin-bottom: 24px;
        }
        .profile-avatar-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e2e8f0;
            background: #28a745;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.25rem;
            font-weight: 700;
        }
        .performance-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }
        .profile-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            font-size: 0.95rem;
        }
        .btn-update-account {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: none !important;
            font-weight: 700;
            padding: 12px 28px;
            border-radius: 8px;
            transition: all 0.25s ease-in-out;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
        }
        .btn-update-account:hover {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
        }
        .btn-update-account:active {
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <small class="text-muted text-uppercase fw-bold">OVERVIEW</small>
            <h2 class="fw-bold" style="color: #1e3a8a;">{{ $user->name }} ({{ $user->id }})</h2>
        </div>

        <div class="profile-card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employee.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Profile Avatar -->
                <div class="profile-avatar-wrapper">
                    @if($user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image))
                        <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" class="profile-avatar-img mb-2">
                    @else
                        <div class="profile-avatar-img mb-2">{{ substr($user->name, 0, 1) }}</div>
                    @endif
                    <h5 class="fw-bold text-dark mb-0">{{ $user->name }}</h5>
                    <small class="text-muted">PM / Employee</small>

                    <div class="mt-2">
                        <label for="avatarInput" class="btn btn-sm btn-outline-success rounded-pill px-3">
                            <i class="bi bi-camera me-1"></i> Change Pic
                        </label>
                        <input type="file" id="avatarInput" name="avatar" class="d-none" onchange="this.form.submit()">
                    </div>
                </div>

                <!-- Performance Metric Box -->
                <div class="performance-box">
                    <span class="text-muted fw-medium">Performance</span>
                    <span class="fw-bold text-dark">0%</span>
                </div>

                <!-- Account Details -->
                <h6 class="fw-bold text-dark mb-3">Account Details</h6>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Username</label>
                    <input type="text" class="form-control" value="{{ strtolower(str_replace(' ', '_', $user->name)) }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Email</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Gender</label>
                    <input type="text" name="gender" class="form-control" placeholder="Male / Female" value="{{ old('gender', $user->gender ?? 'male') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Address" value="{{ old('address', $user->address) }}">
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label text-muted small fw-semibold">City</label>
                        <input type="text" name="city" class="form-control" placeholder="City" value="{{ old('city', $user->city ?? 'Lahore') }}">
                    </div>
                    <div class="col-6">
                        <label class="form-label text-muted small fw-semibold">Country</label>
                        <input type="text" name="country" class="form-control" placeholder="Country" value="{{ old('country', $user->country ?? 'Pakistan') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Phone / WhatsApp</label>
                    <input type="text" name="phone" class="form-control" placeholder="wa.me/923454358142" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Bank Name / Wallet</label>
                    <input type="text" name="bank_name" class="form-control" placeholder="Jazz cash / EasyPaisa / Bank" value="{{ old('bank_name', 'Jazz cash') }}">
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">Account #</label>
                    <input type="text" name="account_number" class="form-control" placeholder="03037575909" value="{{ old('account_number', '03037575909') }}">
                </div>

                <button type="submit" class="btn btn-primary btn-update-account" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-check-lg me-1"></i> Update Account
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
