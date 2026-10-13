@extends('admin.layouts.main')

@push('title')
    <title>Admin Support & Helpdesk - Management Portal</title>
@endpush

@push('style')
<style>
    .support-stat-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    .support-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
    }
    .support-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .support-main-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }
    .support-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        padding: 24px 28px;
    }
    .support-body {
        padding: 28px;
    }
    .form-control-custom, .form-select-custom {
        border-radius: 10px;
        border: 1.5px solid #e2e8f0;
        background-color: #f8fafc;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus, .form-select-custom:focus {
        background-color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .btn-submit-ticket {
        background: #2563eb;
        border: none;
        color: #ffffff;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
        transition: all 0.2s ease;
    }
    .btn-submit-ticket:hover {
        background: #1d4ed8;
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
    }
    .channel-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 18px;
        transition: all 0.2s ease;
    }
    .channel-box:hover {
        background: #ffffff;
        border-color: #cbd5e1;
    }
    .badge-priority {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center">
                <i class="bi bi-headset text-primary me-2"></i> Admin Support & Helpdesk
            </h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small text-muted">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Support</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill fw-semibold border border-success border-opacity-25">
                <i class="bi bi-circle-fill me-1 small" style="font-size: 0.55rem;"></i> Helpdesk Online
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div class="fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
                <strong class="text-danger">Please check the required fields:</strong>
            </div>
            <ul class="mb-0 ps-4 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Support Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="support-stat-card d-flex align-items-center gap-3">
                <div class="support-stat-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Technical Support</div>
                    <div class="fw-bold text-dark fs-5">Active & Monitored</div>
                    <div class="text-success small fw-medium"><i class="bi bi-clock-history me-1"></i>Avg response &lt; 2 hrs</div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="support-stat-card d-flex align-items-center gap-3">
                <div class="support-stat-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-whatsapp"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">Instant Escalation</div>
                    <div class="fw-bold text-dark fs-5">WhatsApp Direct</div>
                    <a href="https://wa.me/923000000000?text=Hello%20Admin%20Support%20Team" target="_blank" class="text-decoration-none text-success small fw-semibold">
                        Open Chat <i class="bi bi-box-arrow-up-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="support-stat-card d-flex align-items-center gap-3">
                <div class="support-stat-icon bg-info bg-opacity-10 text-info">
                    <i class="bi bi-journal-code"></i>
                </div>
                <div>
                    <div class="text-muted small fw-semibold">System Audit</div>
                    <div class="fw-bold text-dark fs-5">Activity Logs</div>
                    <a href="{{ route('admin.activity') }}" class="text-decoration-none text-info small fw-semibold">
                        View System Logs <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="row g-4">
        <!-- Ticket Submission Form -->
        <div class="col-12 col-lg-8">
            <div class="support-main-card">
                <div class="support-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">Submit Support Ticket</h5>
                        <p class="text-muted small mb-0">Describe your inquiry or technical bug and our admin engineering team will resolve it.</p>
                    </div>
                    <i class="bi bi-ticket-perforated fs-3 text-primary"></i>
                </div>

                <div class="support-body">
                    <form action="{{ route('admin.support.send') }}" method="POST">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small">Department / Category <span class="text-danger">*</span></label>
                                <select name="department" class="form-select form-select-custom @error('department') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select category...</option>
                                    <option value="Payments & PayPal" {{ old('department') == 'Payments & PayPal' ? 'selected' : '' }}>Payments & PayPal Gateway</option>
                                    <option value="Refunds & Delays" {{ old('department') == 'Refunds & Delays' ? 'selected' : '' }}>Refunds & Delay Resolution</option>
                                    <option value="Employee & Roles" {{ old('department') == 'Employee & Roles' ? 'selected' : '' }}>Employee Accounts & Access</option>
                                    <option value="Orders & Shipping" {{ old('department') == 'Orders & Shipping' ? 'selected' : '' }}>Orders, Products & Shipping</option>
                                    <option value="Server & Database" {{ old('department') == 'Server & Database' ? 'selected' : '' }}>Server & Database Performance</option>
                                    <option value="General Technical" {{ old('department') == 'General Technical' ? 'selected' : '' }}>General Technical Inquiry</option>
                                </select>
                                @error('department')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-dark fw-semibold small">Urgency / Priority <span class="text-danger">*</span></label>
                                <select name="priority" class="form-select form-select-custom @error('priority') is-invalid @enderror" required>
                                    <option value="normal" {{ old('priority') == 'normal' ? 'selected' : '' }}>Normal - Standard Request</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - Non-critical Question</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Business Impairment</option>
                                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent - Critical Service Outage</option>
                                </select>
                                @error('priority')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-dark fw-semibold small">Ticket Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" class="form-control form-control-custom @error('subject') is-invalid @enderror" placeholder="e.g. PayPal IPN webhook delay on refunds" required>
                            @error('subject')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-semibold small">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control form-control-custom @error('message') is-invalid @enderror" placeholder="Provide full details, order numbers, error codes or URLs..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 flex-wrap gap-2">
                            <span class="text-muted small">
                                <i class="bi bi-info-circle me-1"></i> Responses will also be sent to your admin email ({{ auth()->user()->email }}).
                            </span>
                            <button type="submit" class="btn btn-submit-ticket">
                                <i class="bi bi-send-fill me-1"></i> Submit Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Side: Contact Channels & Resources -->
        <div class="col-12 col-lg-4">
            <div class="support-main-card mb-4">
                <div class="support-header">
                    <h6 class="fw-bold mb-0 text-dark">Direct Support Channels</h6>
                </div>
                <div class="support-body d-flex flex-column gap-3">
                    <div class="channel-box d-flex align-items-center gap-3">
                        <div class="support-stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-whatsapp"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark small">Senior Support Admin</div>
                            <div class="text-muted small">+92 300 0000000</div>
                            <span class="badge bg-success bg-opacity-10 text-success mt-1 small">Available 24/7</span>
                        </div>
                    </div>

                    <div class="channel-box d-flex align-items-center gap-3">
                        <div class="support-stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-envelope-at"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark small">Operations Email</div>
                            <div class="text-muted small">support@ecommerce-portal.com</div>
                            <span class="badge bg-primary bg-opacity-10 text-primary mt-1 small">Official Channel</span>
                        </div>
                    </div>

                    <div class="channel-box d-flex align-items-center gap-3">
                        <div class="support-stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-credit-card-2-front"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark small">Refunds & Disputes Desk</div>
                            <div class="text-muted small">PayPal & Stripe Disputes Team</div>
                            <a href="{{ route('admin.delay-refunds') }}" class="text-decoration-none small text-warning fw-semibold d-block mt-1">
                                Check Delayed Refunds <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ & Quick Help -->
            <div class="support-main-card">
                <div class="support-header">
                    <h6 class="fw-bold mb-0 text-dark">Quick Tips</h6>
                </div>
                <div class="p-3">
                    <div class="accordion accordion-flush" id="supportFaq">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed px-2 py-2 fw-semibold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    How to resolve held PayPal refunds?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#supportFaq">
                                <div class="accordion-body px-2 py-2 text-muted small">
                                    Visit the <strong>Delay Refunds</strong> page from the sidebar to review proof of refund images and mark status as Approved or Processed.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed px-2 py-2 fw-semibold small" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    How to reset employee credentials?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#supportFaq">
                                <div class="accordion-body px-2 py-2 text-muted small">
                                    Navigate to <strong>Admins / Employees</strong>, find the staff member, click <strong>Reset Pass</strong>, and copy their new credentials.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
