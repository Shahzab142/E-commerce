@extends('employee.layouts.main')

@push('title')
    <title>Change Password - Employee Portal</title>
@endpush

@push('style')
    <style>
        .password-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 520px;
            margin: 0 auto;
        }
        .password-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
            font-size: 0.95rem;
        }
        .btn-update-now {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            padding: 12px 28px !important;
            border-radius: 8px !important;
            transition: all 0.25s ease-in-out !important;
            letter-spacing: 0.3px !important;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;
        }
        .btn-update-now:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.45) !important;
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Change Password</h2>
        </div>

        <div class="password-card">
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

            <div class="mb-4">
                <h6 class="fw-bold text-dark mb-1">Update Password</h6>
                <p class="text-muted small mb-0">
                    Your password must be more than 6 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
                </p>
            </div>

            <form action="{{ route('employee.change-password.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="password" name="old_password" class="form-control" placeholder="Old Password" required>
                </div>

                <div class="mb-3">
                    <input type="password" name="new_password" class="form-control" placeholder="New Password" required>
                </div>

                <div class="mb-4">
                    <input type="password" name="new_password_confirmation" class="form-control" placeholder="Type Again New Password" required>
                </div>

                <button type="submit" class="btn btn-primary btn-update-now" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-shield-lock me-1"></i> Update Now
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
