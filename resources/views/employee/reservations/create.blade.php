@extends('employee.layouts.main')

@push('title')
    <title>Reservation - Employee Portal</title>
@endpush

@push('style')
    <style>
        .form-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
            max-width: 500px;
            margin: 0 auto;
        }
        .form-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 16px;
        }
        .btn-reserve-blue {
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
        .btn-reserve-blue:hover {
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
            <h2 class="fw-bold" style="color: #1e3a8a;">Reservation</h2>
        </div>

        <div class="form-card">
            <h6 class="fw-bold text-dark mb-3">Reserve An Order</h6>

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employee.reservations.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">Product ID</label>
                    <input type="number" name="product_id" class="form-control" placeholder="Product ID" required autofocus>
                </div>

                <button type="submit" class="btn btn-primary btn-reserve-blue" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-calendar-plus me-1"></i> Reserve Now
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
