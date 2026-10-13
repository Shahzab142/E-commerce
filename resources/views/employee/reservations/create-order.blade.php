@extends('employee.layouts.main')

@push('title')
    <title>Create Order - Employee Portal</title>
@endpush

@push('style')
    <style>
        .form-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
            max-width: 550px;
            margin: 0 auto;
        }
        .form-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
        }
        .btn-add-blue {
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
        .btn-add-blue:hover {
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
            <h2 class="fw-bold" style="color: #1e3a8a;">Orders</h2>
        </div>

        <div class="form-card">
            <h6 class="fw-bold text-dark mb-4">Add New Order for Product #{{ $reservation->product_id }} ({{ $reservation->product->name ?? 'Product' }})</h6>

            @if($errors->any())
                <div class="alert alert-danger rounded-3 mb-3">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('employee.reservations.order.store', $reservation->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="text" name="order_number" class="form-control" placeholder="Order Number" required>
                </div>

                <div class="mb-3">
                    <input type="email" name="paypal_email" class="form-control" placeholder="Paypal">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="hasPicUrl">
                    <label class="form-check-label text-muted small" for="hasPicUrl">
                        I have order picture URL
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Order Pic</label>
                    <input type="file" name="order_pic" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Refund Pic</label>
                    <input type="file" name="refund_pic" class="form-control">
                </div>

                <div class="mb-4">
                    <input type="url" name="amz_review_link" class="form-control" placeholder="AMZ Review Link">
                </div>

                <button type="submit" class="btn btn-primary btn-add-blue" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-plus-circle me-1"></i> Add Now
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
