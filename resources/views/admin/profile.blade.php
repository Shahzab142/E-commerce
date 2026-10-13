@extends('admin.layouts.main')

@push('title')
    <title>Admin Profile - Khyber Pro</title>
@endpush

@push('style')
    <style>
        .card-clean {
            background: #ffffff;
            border: 1px solid #eef2f6;
            border-radius: 14px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        /* Avatar & Photo Upload */
        .profile-avatar-wrap {
            position: relative;
            width: 130px;
            height: 130px;
            margin: 0 auto;
        }
        .profile-avatar-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background: #ffffff;
            border: 4px solid #ffffff;
            box-shadow: 0 0 0 3px #eef2f6, 0 10px 25px -5px rgba(15, 23, 42, 0.1);
        }
        .profile-photo-btn {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #16a34a;
            color: #ffffff;
            border: 2px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(22, 163, 74, 0.35);
            transition: all 0.2s ease;
        }
        .profile-photo-btn:hover {
            background: #15803d;
            transform: scale(1.05);
        }
        .profile-photo-btn input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        /* Business Logo Box */
        .profile-logo-wrap {
            position: relative;
            width: 76px;
            height: 76px;
            flex-shrink: 0;
        }
        .profile-logo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
        }
        .profile-logo-wrap .profile-photo-btn {
            bottom: -5px;
            right: -5px;
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }

        /* Left Info List */
        .info-pill-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
            color: #334155;
        }
        .info-pill-item:last-child {
            border-bottom: none;
        }
        .info-icon-box {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.95rem;
        }

        /* Seamless Tab Navigation (No Horizontal Scrollbar) */
        .profile-tabs-nav {
            display: flex;
            gap: 8px;
            border-bottom: 1px solid #eef2f6;
            padding: 14px 20px 0 20px;
            background: #f8fafc;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .profile-tabs-nav::-webkit-scrollbar {
            display: none;
        }
        .profile-tab-btn {
            border: none;
            background: transparent;
            padding: 10px 18px;
            font-weight: 600;
            font-size: 0.88rem;
            color: #64748b;
            border-radius: 10px 10px 0 0;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .profile-tab-btn:hover {
            color: #0f172a;
        }
        .profile-tab-btn.active {
            color: #16a34a;
            background: #ffffff;
            border-bottom: 2px solid #16a34a;
        }
        .profile-tab-pane {
            display: none;
        }
        .profile-tab-pane.active {
            display: block;
        }

        /* Professional Form Inputs */
        .form-label-pro {
            font-size: 0.82rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }
        .form-control-pro, .form-select-pro {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 9px 14px;
            font-size: 0.88rem;
            color: #0f172a;
            transition: all 0.15s ease;
        }
        .form-control-pro:focus, .form-select-pro:focus {
            background-color: #ffffff;
            border-color: #16a34a;
            box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.12);
            outline: none;
        }
    </style>
@endpush

@section('content')
<main style="background-color: #f8fafc; min-height: 100vh;">
    <div class="container-fluid px-3 px-md-4 py-4 pb-5">

        {{-- Clean Modern Header --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Admin Profile</h2>
                <p class="text-muted small mb-0">Manage personal details, business info, and payment settings</p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold">
                    <i class="bi bi-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Please check the errors:</strong>
                <ul class="mb-0 mt-1 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4">

            {{-- Left Column: Profile Summary Card --}}
            <div class="col-lg-4">
                <div class="card card-clean p-4 text-center h-100">
                    <div class="profile-avatar-wrap mb-3">
                        <img id="avatar-preview" src="{{ $user->adminDetail?->image ? asset('storage/'.$user->adminDetail->image) : asset('assets/images/user.png') }}" alt="Profile photo">
                        <label class="profile-photo-btn" title="Change profile picture">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" data-preview="avatar-preview" form="admin-profile-form" name="image" accept="image/png, image/jpeg, image/webp">
                        </label>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                    <div>
                        <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-3 py-1.5 rounded-pill fw-semibold" style="font-size: 0.78rem;">
                            <i class="bi bi-shield-check me-1"></i> Administrator
                        </span>
                    </div>

                    <hr class="my-3 border-light">

                    <div class="text-start">
                        <div class="info-pill-item">
                            <span class="info-icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <span class="text-truncate fw-medium">{{ $user->email }}</span>
                        </div>
                        <div class="info-pill-item">
                            <span class="info-icon-box bg-success bg-opacity-10 text-success">
                                <i class="bi bi-telephone-fill"></i>
                            </span>
                            <span>{{ $user->phone ?: 'Phone not set' }}</span>
                        </div>
                        <div class="info-pill-item">
                            <span class="info-icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>
                            <span>{{ $user->adminDetail?->city ?: 'Location not set' }}{{ $user->adminDetail?->country ? ', '.$user->adminDetail->country : '' }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top border-light text-start">
                        <div class="d-flex justify-content-between align-items-center small text-muted">
                            <span>Account Status</span>
                            <span class="badge bg-success text-white rounded-pill px-2.5 py-1">Active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Tabbed Settings Form --}}
            <div class="col-lg-8">
                <div class="card card-clean h-100">

                    {{-- Clean Tab Navigation --}}
                    <div class="profile-tabs-nav">
                        <button type="button" class="profile-tab-btn active" data-tab="personal">
                            <i class="bi bi-person-fill"></i> Personal Information
                        </button>
                        <button type="button" class="profile-tab-btn" data-tab="business">
                            <i class="bi bi-shop"></i> Business Information
                        </button>
                        <button type="button" class="profile-tab-btn" data-tab="payment">
                            <i class="bi bi-credit-card-fill"></i> Payment Information
                        </button>
                    </div>

                    <div class="p-4">
                        <form id="admin-profile-form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            {{-- TAB 1: PERSONAL INFORMATION --}}
                            <div class="profile-tab-pane active" id="tab-personal">
                                <h6 class="fw-bold text-dark mb-3">Basic Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-pro">ID (Identification Number)</label>
                                        <input type="text" name="id_number" class="form-control form-control-pro" value="{{ old('id_number', $user->adminDetail?->id_number) }}" placeholder="e.g. 12345-6789901">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control form-control-pro" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control form-control-pro" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Phone Number</label>
                                        <input type="text" name="phone" class="form-control form-control-pro" value="{{ old('phone', $user->phone) }}" placeholder="+92 300 1234567">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Country</label>
                                        @php($currentCountry = old('country', $user->adminDetail?->country))
                                        <select class="form-select form-select-pro" name="country">
                                            <option value="" @selected(! $currentCountry)>Select country</option>
                                            <option value="Pakistan" @selected($currentCountry === 'Pakistan')>Pakistan</option>
                                            <option value="United Arab Emirates" @selected($currentCountry === 'United Arab Emirates')>United Arab Emirates</option>
                                            <option value="Saudi Arabia" @selected($currentCountry === 'Saudi Arabia')>Saudi Arabia</option>
                                            <option value="United Kingdom" @selected($currentCountry === 'United Kingdom')>United Kingdom</option>
                                            <option value="United States" @selected($currentCountry === 'United States')>United States</option>
                                            <option value="India" @selected($currentCountry === 'India')>India</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">State / Province</label>
                                        <input type="text" name="state" class="form-control form-control-pro" value="{{ old('state', $user->adminDetail?->state) }}" placeholder="e.g. Khyber Pakhtunkhwa">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">City</label>
                                        <input type="text" name="city" class="form-control form-control-pro" value="{{ old('city', $user->adminDetail?->city) }}" placeholder="e.g. Peshawar">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Postal / Pin Code</label>
                                        <input type="text" name="postal_code" class="form-control form-control-pro" value="{{ old('postal_code', $user->adminDetail?->postal_code) }}" placeholder="e.g. 25000">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-pro">Address</label>
                                        <textarea class="form-control form-control-pro" name="address" rows="2" placeholder="Enter physical street address">{{ old('address', $user->adminDetail?->address) }}</textarea>
                                    </div>
                                </div>

                                <hr class="my-4 border-light">

                                <h6 class="fw-bold text-dark mb-1">Security / Password</h6>
                                <p class="text-muted small mb-3">Leave blank if you do not want to change your current password.</p>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label-pro">Current Password</label>
                                        <input type="password" name="current_password" class="form-control form-control-pro" placeholder="••••••••">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-pro">New Password</label>
                                        <input type="password" name="password" class="form-control form-control-pro" placeholder="••••••••">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-pro">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-pro" placeholder="••••••••">
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 2: BUSINESS INFORMATION --}}
                            <div class="profile-tab-pane" id="tab-business">
                                <h6 class="fw-bold text-dark mb-3">Store & Company Details</h6>

                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 mb-4" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="profile-logo-wrap">
                                        <img id="logo-preview" src="{{ $user->adminDetail?->logo ? asset('storage/'.$user->adminDetail->logo) : asset('assets/images/user.png') }}" alt="Business logo">
                                        <label class="profile-photo-btn" title="Change business logo">
                                            <i class="bi bi-camera-fill"></i>
                                            <input type="file" data-preview="logo-preview" form="admin-profile-form" name="logo" accept="image/png, image/jpeg, image/webp">
                                        </label>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-dark mb-0.5">Brand / Store Logo</div>
                                        <div class="text-muted small">Square image recommended (min 200x200px, PNG or JPG).</div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Business Name</label>
                                        <input type="text" name="business_name" class="form-control form-control-pro" value="{{ old('business_name', $user->adminDetail?->business_name) }}" placeholder="e.g. Khyber Pro Store">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Business Category</label>
                                        @php($currentCategory = old('business_category', $user->adminDetail?->business_category))
                                        <select class="form-select form-select-pro" name="business_category">
                                            <option value="" @selected(! $currentCategory)>Select category</option>
                                            @foreach (['Clothing & Apparel', 'Electronics', 'Groceries', 'Home & Living', 'Beauty & Personal Care', 'Other'] as $option)
                                                <option value="{{ $option }}" @selected($currentCategory === $option)>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Business Type</label>
                                        @php($currentType = old('business_type', $user->adminDetail?->business_type))
                                        <select class="form-select form-select-pro" name="business_type">
                                            <option value="" @selected(! $currentType)>Select type</option>
                                            @foreach (['Sole Proprietorship', 'Partnership', 'Private Limited', 'Other'] as $option)
                                                <option value="{{ $option }}" @selected($currentType === $option)>{{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Established Year</label>
                                        <input type="number" name="established_year" class="form-control form-control-pro" value="{{ old('established_year', $user->adminDetail?->established_year) }}" placeholder="e.g. 2024" min="1900" id="est-year">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Registration Number</label>
                                        <input type="text" name="registration_number" class="form-control form-control-pro" value="{{ old('registration_number', $user->adminDetail?->registration_number) }}" placeholder="e.g. REG-00123456">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">NTN / Tax Number</label>
                                        <input type="text" name="tax_number" class="form-control form-control-pro" value="{{ old('tax_number', $user->adminDetail?->tax_number) }}" placeholder="e.g. 1234567-8">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Business Email</label>
                                        <input type="email" name="business_email" class="form-control form-control-pro" value="{{ old('business_email', $user->adminDetail?->business_email) }}" placeholder="support@khyberpro.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-pro">Business Phone</label>
                                        <input type="text" name="business_phone" class="form-control form-control-pro" value="{{ old('business_phone', $user->adminDetail?->business_phone) }}" placeholder="+92 300 0000000">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-pro">Website URL (Optional)</label>
                                        <input type="url" name="website" class="form-control form-control-pro" value="{{ old('website', $user->adminDetail?->website) }}" placeholder="https://khyberpro.com">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-pro">Business / Warehouse Address</label>
                                        <textarea class="form-control form-control-pro" name="business_address" rows="2" placeholder="Store or warehouse address">{{ old('business_address', $user->adminDetail?->business_address) }}</textarea>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label-pro">Store Description</label>
                                        <textarea class="form-control form-control-pro" name="business_description" rows="2" placeholder="Short description displayed on public store page">{{ old('business_description', $user->adminDetail?->business_description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- TAB 3: PAYMENT INFORMATION --}}
                            <div class="profile-tab-pane" id="tab-payment">
                                <h6 class="fw-bold text-dark mb-1">Manual Payment Accounts</h6>
                                <p class="text-muted small mb-3">
                                    Customers can view these details during manual checkout (Easypaisa, JazzCash, or Bank Transfer).
                                </p>

                                <div class="row g-3">
                                    {{-- Easypaisa --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                            <div class="fw-bold text-success mb-2 small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-wallet2"></i> Easypaisa Account
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label-pro">Easypaisa Mobile Number</label>
                                                <input type="text" name="easypaisa_number" class="form-control form-control-pro bg-white" value="{{ old('easypaisa_number', $user->adminDetail?->easypaisa_number) }}" placeholder="+92 300 0000000">
                                            </div>
                                            <div>
                                                <label class="form-label-pro">Account Title</label>
                                                <input type="text" name="easypaisa_account_title" class="form-control form-control-pro bg-white" value="{{ old('easypaisa_account_title', $user->adminDetail?->easypaisa_account_title) }}" placeholder="e.g. Muhammad Khan">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- JazzCash --}}
                                    <div class="col-md-6">
                                        <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                            <div class="fw-bold text-danger mb-2 small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-phone"></i> JazzCash Account
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label-pro">JazzCash Mobile Number</label>
                                                <input type="text" name="jazzcash_number" class="form-control form-control-pro bg-white" value="{{ old('jazzcash_number', $user->adminDetail?->jazzcash_number) }}" placeholder="+92 300 0000000">
                                            </div>
                                            <div>
                                                <label class="form-label-pro">Account Title</label>
                                                <input type="text" name="jazzcash_account_title" class="form-control form-control-pro bg-white" value="{{ old('jazzcash_account_title', $user->adminDetail?->jazzcash_account_title) }}" placeholder="e.g. Muhammad Khan">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Bank Transfer --}}
                                    <div class="col-12">
                                        <div class="p-3 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                            <div class="fw-bold text-primary mb-2 small d-flex align-items-center gap-1.5">
                                                <i class="bi bi-bank"></i> Bank Account Transfer
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label-pro">Bank Name</label>
                                                    <input type="text" name="bank_name" class="form-control form-control-pro bg-white" value="{{ old('bank_name', $user->adminDetail?->bank_name) }}" placeholder="e.g. Meezan Bank / HBL">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-pro">Account Title</label>
                                                    <input type="text" name="account_title" class="form-control form-control-pro bg-white" value="{{ old('account_title', $user->adminDetail?->account_title) }}" placeholder="Full Name on Bank Account">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-pro">Account Number</label>
                                                    <input type="text" name="account_number" class="form-control form-control-pro bg-white" value="{{ old('account_number', $user->adminDetail?->account_number) }}" placeholder="e.g. 0123456789012">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label-pro">IBAN</label>
                                                    <input type="text" name="iban" class="form-control form-control-pro bg-white" value="{{ old('iban', $user->adminDetail?->iban) }}" placeholder="e.g. PK00MEZN0000000000000000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-light border small mt-3 mb-0 text-muted">
                                    <i class="bi bi-shield-lock-fill text-success me-1"></i> These details are securely shown to customers during manual checkout.
                                </div>
                            </div>

                            {{-- Form Actions Footer --}}
                            <div class="mt-4 pt-3 border-top border-light d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold">Cancel</button>
                                <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                    <i class="bi bi-check-circle me-1"></i> Save Changes
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>

    </div>
</main>

<script>
    // Established Year max = current year
    const estYearInput = document.getElementById('est-year');
    if (estYearInput) {
        estYearInput.max = new Date().getFullYear();
    }

    // Shared avatar / logo image preview
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;
            const preview = document.getElementById(input.dataset.preview);
            if (!preview) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    });

    // Tab switching
    const tabButtons = document.querySelectorAll('.profile-tab-btn');
    tabButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            tabButtons.forEach((b) => b.classList.remove('active'));
            document.querySelectorAll('.profile-tab-pane').forEach((p) => p.classList.remove('active'));
            btn.classList.add('active');
            const targetPane = document.getElementById('tab-' + btn.dataset.tab);
            if (targetPane) {
                targetPane.classList.add('active');
            }
        });
    });
</script>
@endsection
