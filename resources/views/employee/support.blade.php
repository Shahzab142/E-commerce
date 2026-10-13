@extends('employee.layouts.main')

@push('title')
    <title>Employee Support - Khyber Pro</title>
@endpush

@push('style')
    <style>
        .support-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 32px;
            max-width: 600px;
            margin: 0 auto;
        }
        .support-card .form-control {
            border-radius: 8px;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            padding: 12px 16px;
        }
        .btn-send-blue {
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
        .btn-send-blue:hover {
            background-color: #1d4ed8 !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.4);
        }
        .btn-send-blue:active {
            transform: translateY(0);
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container-fluid px-2">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Support</h2>
        </div>

        <div class="support-card">
            <div class="d-flex align-items-center gap-3 mb-4">
                <i class="bi bi-headset fs-1 text-success"></i>
                <div>
                    <h5 class="fw-bold text-dark mb-1">Employee Helpdesk</h5>
                    <p class="text-muted small mb-0">Need assistance with an order, reservation or refund dispute? Send us a message.</p>
                </div>
            </div>

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-muted small fw-semibold">Subject</label>
                    <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-semibold">Message</label>
                    <textarea name="message" class="form-control" rows="5" placeholder="Describe your issue or request..." required></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-send-blue" style="background-color: #2563eb !important; border-color: #2563eb !important; color: #ffffff !important; font-weight: 700 !important; padding: 12px 28px !important; border-radius: 8px !important; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35) !important;">
                    <i class="bi bi-send me-1"></i> Send Support Request
                </button>
            </form>
        </div>
    </div>
</main>
@endsection
