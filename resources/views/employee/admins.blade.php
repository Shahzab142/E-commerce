@extends('employee.layouts.main')

@push('title')
    <title>Active Admins - Employee Portal</title>
    <style>
        .admins-card {
            border: none;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.07);
            padding: 28px;
        }
        .btn-wa {
            background-color: #22c55e;
            color: #ffffff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            text-decoration: none;
            transition: transform 0.2s;
        }
        .btn-wa:hover {
            background-color: #16a34a;
            color: #ffffff;
            transform: scale(1.08);
        }
    </style>
@endpush

@section('content')
<main>
    <div class="container px-2" style="max-width: 900px;">
        <div class="text-center mb-4">
            <h2 class="fw-bold" style="color: #1e3a8a;">Admins</h2>
        </div>

        <div class="admins-card">
            <h5 class="fw-bold mb-4 text-dark">Active Admins</h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">#</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th style="width: 100px;" class="text-center">Contact</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $admin)
                        <tr>
                            <td class="text-muted fw-semibold">{{ $admin['id'] }}</td>
                            <td class="fw-bold text-dark">{{ $admin['name'] }}</td>
                            <td>
                                <span class="badge bg-light text-secondary border px-3 py-2 fs-6 fw-medium text-wrap text-start">
                                    {{ $admin['role'] }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($admin['whatsapp'])
                                    <a href="https://wa.me/{{ $admin['whatsapp'] }}" target="_blank" class="btn-wa" title="Contact on WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">none</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
