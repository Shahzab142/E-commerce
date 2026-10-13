@extends('user.layouts.main')

@section('title', 'Account Settings')

@push('styles')

<style>

    :root {
        --acc-primary: #4f46e5;
        --acc-primary-dark: #4338ca;
        --acc-purple: #7c3aed;
        --acc-surface: #ffffff;
        --acc-bg: #f7f8fc;
        --acc-border: #e9eaf0;
        --acc-text: #22232e;
        --acc-text-muted: #7c7f8e;
        --acc-radius: 18px;
    }

    .account-settings-page {
        min-height: 100%;
        background: var(--acc-bg);
    }

    .acc-header {
        position: relative;
        overflow: hidden;
        padding: 2rem 2.25rem;
        color: #fff;
        background: linear-gradient(
            120deg,
            var(--acc-primary) 0%,
            #6d5dfc 50%,
            var(--acc-purple) 100%
        );
        border-radius: var(--acc-radius);
        box-shadow: 0 12px 30px rgba(79,70,229,.12);
    }

    .acc-header::before {
        content: "";
        position: absolute;
        width: 240px;
        height: 240px;
        top: -120px;
        right: -70px;
        border-radius: 50%;
        background: rgba(255,255,255,.08);
    }

    .acc-header::after {
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        bottom: -120px;
        left: 30%;
        border-radius: 50%;
        background: rgba(255,255,255,.05);
    }

    .acc-header-content {
        position: relative;
        z-index: 1;
    }

    .acc-header h2 {
        margin-bottom: .35rem;
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        letter-spacing: -.03em;
    }

    .acc-header p {
        max-width: 700px;
        margin: 0;
        color: rgba(255,255,255,.82);
        font-size: .9rem;
    }

    .acc-card {
        overflow: hidden;
        height: 100%;
        background: var(--acc-surface);
        border: 1px solid var(--acc-border);
        border-radius: var(--acc-radius);
        box-shadow: 0 8px 28px rgba(20,20,43,.045);
    }

    .acc-card .card-header {
        background: transparent;
        border-bottom: 1px solid var(--acc-border);
    }

    .acc-section-title {
        color: var(--acc-text);
        font-size: 1rem;
        font-weight: 800;
    }

    .acc-label {
        margin-bottom: .4rem;
        color: #3d3f4d;
        font-size: .82rem;
        font-weight: 700;
    }

    .acc-input {
        min-height: 44px;
        color: var(--acc-text);
        background: #fff;
        border: 1px solid #e1e3eb;
        border-radius: 11px;
        font-size: .88rem;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .acc-input:focus {
        color: var(--acc-text);
        background: #fff;
        border-color: var(--acc-primary);
        box-shadow: 0 0 0 .2rem rgba(79,70,229,.1);
    }

    textarea.acc-input {
        min-height: auto;
    }

    .acc-avatar-wrap {
        position: relative;
        width: 148px;
        height: 148px;
        margin: 0 auto;
    }

    .acc-avatar-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 5px solid #fff;
        border-radius: 50%;
        box-shadow:
            0 0 0 4px var(--acc-border),
            0 10px 30px rgba(20,20,43,.1);
    }

    .acc-avatar-btn {
        position: absolute;
        right: 2px;
        bottom: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        color: #fff;
        background: var(--acc-primary);
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(79,70,229,.3);
        cursor: pointer;
        transition: .2s ease;
    }

    .acc-avatar-btn:hover {
        color: #fff;
        background: var(--acc-primary-dark);
        transform: scale(1.06);
    }

    .acc-avatar-btn input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .acc-badge-role {
        display: inline-block;
        padding: .35rem .85rem;
        color: var(--acc-primary);
        background: rgba(79,70,229,.08);
        border-radius: 50px;
        font-size: .75rem;
        font-weight: 700;
    }

    .acc-info-row {
        display: flex;
        align-items: center;
        gap: .75rem;
        padding: .7rem 0;
        border-bottom: 1px solid var(--acc-border);
        font-size: .88rem;
    }

    .acc-info-row:last-child {
        border-bottom: 0;
    }

    .acc-info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 38px;
        width: 38px;
        height: 38px;
        border-radius: 11px;
    }

    .acc-icon-mail {
        color: var(--acc-primary);
        background: rgba(79,70,229,.09);
    }

    .acc-icon-phone {
        color: #198754;
        background: rgba(25,135,84,.09);
    }

    .acc-icon-loc {
        color: #dc3545;
        background: rgba(220,53,69,.09);
    }

    .btn-acc-primary {
        color: #fff;
        background: var(--acc-primary);
        border-color: var(--acc-primary);
        border-radius: 10px;
        padding: .65rem 1.35rem;
        font-weight: 700;
        transition: .2s ease;
    }

    .btn-acc-primary:hover {
        color: #fff;
        background: var(--acc-primary-dark);
        border-color: var(--acc-primary-dark);
        transform: translateY(-1px);
    }

    .btn-acc-outline {
        color: #6b6e7c;
        background: #fff;
        border: 1px solid #e1e3eb;
        border-radius: 10px;
        padding: .65rem 1.35rem;
        font-weight: 700;
    }

    .btn-acc-outline:hover {
        color: var(--acc-primary);
        background: rgba(79,70,229,.04);
        border-color: rgba(79,70,229,.25);
    }

    .acc-pay-method {
        display: flex;
        align-items: center;
        gap: .7rem;
        height: 100%;
        padding: .9rem 1rem;
        background: #fff;
        border: 1px solid var(--acc-border);
        border-radius: 12px;
    }

    .acc-pay-method input {
        accent-color: var(--acc-primary);
    }

    .acc-pay-method.acc-pay-active {
        background: rgba(79,70,229,.04);
        border-color: var(--acc-primary);
    }

    @media (max-width: 767.98px) {

        .acc-header {
            padding: 1.5rem;
        }

        .acc-card .p-4 {
            padding: 1rem !important;
        }

        .acc-avatar-wrap {
            width: 125px;
            height: 125px;
        }

        .acc-info-row {
            align-items: flex-start;
        }

        .btn-acc-primary,
        .btn-acc-outline {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')

<div class="account-settings-page">

    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="acc-header mb-4">

            <div class="acc-header-content">

                <h2>
                    Account Settings
                </h2>

                <p>
                    Manage your personal information, profile photo,
                    security preferences, payment methods and shipping addresses.
                </p>

            </div>

        </div>


        {{-- Success Message --}}
        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4"
                 role="alert">

                <div class="d-flex align-items-center">

                    <i class="bi bi-check-circle-fill fs-5 me-2"></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4"
                 role="alert">

                <div class="d-flex align-items-start">

                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>

                    <div>

                        <strong>
                            Please correct the following errors:
                        </strong>

                        <ul class="mb-0 mt-2 ps-3">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close">
                </button>

            </div>

        @endif


        {{-- Main Settings Content --}}
        <div class="row g-4">

            {{-- Profile --}}
            <div class="col-12 col-lg-4">

                <div class="acc-card p-4 text-center">

                    <div class="acc-avatar-wrap">

                        <img
                            id="acc-avatar-preview"
                            src="{{ $user->image
                                ? asset('storage/' . $user->image)
                                : asset('assets/images/user.png') }}"
                            alt="{{ $user->name }}"
                        >

                        <label
                            class="acc-avatar-btn"
                            title="Change profile picture"
                        >

                            <i class="bi bi-camera-fill"></i>

                            <input
                                type="file"
                                id="acc-avatar-input"
                                name="image"
                                form="acc-form"
                                accept="image/png,image/jpeg,image/webp"
                            >

                        </label>

                    </div>


                    <h4 class="mt-4 mb-1 fw-bold">
                        {{ $user->name }}
                    </h4>

                    <span class="acc-badge-role">
                        <i class="bi bi-person-fill me-1"></i>
                        {{ ucfirst($user->role) }}
                    </span>


                    <hr class="my-4">


                    <div class="text-start">

                        <div class="acc-info-row">

                            <span class="acc-info-icon acc-icon-mail">
                                <i class="bi bi-envelope-fill"></i>
                            </span>

                            <div class="text-truncate">

                                <small class="d-block text-muted">
                                    Email
                                </small>

                                <span class="fw-semibold text-break">
                                    {{ $user->email }}
                                </span>

                            </div>

                        </div>


                        <div class="acc-info-row">

                            <span class="acc-info-icon acc-icon-phone">
                                <i class="bi bi-telephone-fill"></i>
                            </span>

                            <div>

                                <small class="d-block text-muted">
                                    Phone
                                </small>

                                <span class="fw-semibold">
                                    {{ $user->phone ?: 'Not set' }}
                                </span>

                            </div>

                        </div>


                        <div class="acc-info-row">

                            <span class="acc-info-icon acc-icon-loc">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>

                            <div>

                                <small class="d-block text-muted">
                                    Location
                                </small>

                                <span class="fw-semibold">

                                    {{ $user->userDetail?->city ?: 'Not set' }}

                                    @if ($user->userDetail?->country)
                                        , {{ $user->userDetail->country }}
                                    @endif

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Personal Information --}}
            <div class="col-12 col-lg-8">

                <div class="acc-card">

                    <div class="card-header py-3 px-4">

                        <h5 class="acc-section-title mb-0">

                            <i class="bi bi-person-lines-fill me-2"></i>

                            Personal Information

                        </h5>

                    </div>


                    <div class="p-4">

                        <form
                            action="{{ route('user.settings.update') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            id="acc-form"
                        >

                            @csrf

                            @method('PATCH')


                            <div class="row g-3">

                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Full Name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control acc-input @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Email Address
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control acc-input @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >

                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Phone Number
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control acc-input"
                                        value="{{ old('phone', $user->phone) }}"
                                        placeholder="+92"
                                    >

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Country
                                    </label>

                                    @php
                                        $currentCountry = old(
                                            'country',
                                            $user->userDetail?->country
                                        );
                                    @endphp

                                    <select
                                        class="form-select acc-input"
                                        name="country"
                                    >

                                        <option
                                            value=""
                                            @selected(!$currentCountry)
                                        >
                                            Select country
                                        </option>

                                        <option
                                            value="Pakistan"
                                            @selected($currentCountry === 'Pakistan')
                                        >
                                            Pakistan
                                        </option>

                                        <option
                                            value="India"
                                            @selected($currentCountry === 'India')
                                        >
                                            India
                                        </option>

                                        <option
                                            value="United Arab Emirates"
                                            @selected($currentCountry === 'United Arab Emirates')
                                        >
                                            United Arab Emirates
                                        </option>

                                        <option
                                            value="Saudi Arabia"
                                            @selected($currentCountry === 'Saudi Arabia')
                                        >
                                            Saudi Arabia
                                        </option>

                                        <option
                                            value="United Kingdom"
                                            @selected($currentCountry === 'United Kingdom')
                                        >
                                            United Kingdom
                                        </option>

                                        <option
                                            value="United States"
                                            @selected($currentCountry === 'United States')
                                        >
                                            United States
                                        </option>

                                    </select>

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        State / Province
                                    </label>

                                    <input
                                        type="text"
                                        name="state"
                                        class="form-control acc-input"
                                        value="{{ old('state', $user->userDetail?->state) }}"
                                        placeholder="Punjab"
                                    >

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        City
                                    </label>

                                    <input
                                        type="text"
                                        name="city"
                                        class="form-control acc-input"
                                        value="{{ old('city', $user->userDetail?->city) }}"
                                        placeholder="Lahore"
                                    >

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Postal Code
                                    </label>

                                    <input
                                        type="text"
                                        name="postal_code"
                                        class="form-control acc-input"
                                        value="{{ old('postal_code', $user->userDetail?->postal_code) }}"
                                        placeholder="e.g. 54000"
                                    >

                                </div>


                                <div class="col-12 col-md-6">

                                    <label class="form-label acc-label">
                                        Landmark
                                    </label>

                                    <input
                                        type="text"
                                        name="landmark"
                                        class="form-control acc-input"
                                        value="{{ old('landmark', $user->userDetail?->landmark) }}"
                                        placeholder="Nearby landmark"
                                    >

                                </div>


                                <div class="col-12">

                                    <label class="form-label acc-label">
                                        Address
                                    </label>

                                    <textarea
                                        class="form-control acc-input"
                                        name="address"
                                        rows="3"
                                        placeholder="Enter your complete address"
                                    >{{ old('address', $user->userDetail?->address) }}</textarea>

                                </div>

                            </div>


                            <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">

                                <button
                                    type="reset"
                                    class="btn btn-acc-outline"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-acc-primary"
                                >
                                    <i class="bi bi-check-circle me-1"></i>
                                    Save Changes
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>


        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="acc-card">
                    <div class="card-header py-3 px-4">
                        <h5 class="acc-section-title mb-0">
                            <i class="bi bi-wallet2 me-2"></i>Payment Methods (For Commission)
                        </h5>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('user.settings.payment-methods.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label acc-label">Provider</label>
                                    <select name="type" class="form-select acc-input" required>
                                        <option value="jazzcash">JazzCash</option>
                                        <option value="easypaisa">EasyPaisa</option>
                                        <option value="bank">Bank Transfer</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label acc-label">Account Title</label>
                                    <input type="text" name="account_title" class="form-control acc-input" required placeholder="Name on Account">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label acc-label">Account Number</label>
                                    <input type="text" name="account_number" class="form-control acc-input" required placeholder="03XXXXXXXXX">
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-acc-primary"><i class="bi bi-plus-circle me-1"></i>Add Payment Method</button>
                                </div>
                            </div>
                        </form>

                        @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                            <hr>
                            <h6 class="mb-3 mt-4 fw-bold">Saved Payment Methods</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Type</th>
                                            <th>Account Title</th>
                                            <th>Account Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentMethods as $pm)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ strtoupper($pm->type) }}</span></td>
                                            <td>{{ $pm->account_title }}</td>
                                            <td>{{ $pm->account_number }}</td>
                                            <td>
                                                @if($pm->is_default)
                                                    <span class="badge bg-success">Default</span>
                                                @else
                                                    <span class="text-muted">Active</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('user.settings.payment-methods.delete', $pm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment method?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-2">
            <div class="col-12">
                <div class="acc-card">
                    <div class="card-header py-3 px-4">
                        <h5 class="acc-section-title mb-0">
                            <i class="bi bi-geo-alt me-2"></i>Saved Shipping Addresses
                        </h5>
                    </div>
                    <div class="p-4">
                        <form action="{{ route('user.settings.shipping-addresses.store') }}" method="POST" class="mb-4">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label acc-label">Label (e.g. Home, Work)</label>
                                    <input type="text" name="label" class="form-control acc-input" placeholder="Home">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label acc-label">Full Name</label>
                                    <input type="text" name="full_name" class="form-control acc-input" required placeholder="Full Name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label acc-label">Phone</label>
                                    <input type="text" name="phone" class="form-control acc-input" placeholder="+923001234567">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label acc-label">City</label>
                                    <input type="text" name="city" class="form-control acc-input" placeholder="Lahore">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label acc-label">Street Address</label>
                                    <input type="text" name="address" class="form-control acc-input" required placeholder="Complete street address">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label acc-label">State / Province</label>
                                    <input type="text" name="state" class="form-control acc-input" placeholder="Punjab">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label acc-label">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-control acc-input" placeholder="54000">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label acc-label">Country</label>
                                    <input type="text" name="country" class="form-control acc-input" placeholder="Pakistan">
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-acc-primary"><i class="bi bi-plus-circle me-1"></i>Add Shipping Address</button>
                                </div>
                            </div>
                        </form>

                        @if(isset($shippingAddresses) && $shippingAddresses->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Label</th>
                                            <th>Recipient</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shippingAddresses as $addr)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $addr->label ?? 'Address' }}</span></td>
                                            <td>{{ $addr->full_name }}</td>
                                            <td>{{ $addr->address }}, {{ $addr->city }}</td>
                                            <td>{{ $addr->phone ?? '—' }}</td>
                                            <td>
                                                @if($addr->is_default)
                                                    <span class="badge bg-success">Default</span>
                                                @else
                                                    <form action="{{ route('user.settings.shipping-addresses.default', $addr->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Set Default</button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('user.settings.shipping-addresses.delete', $addr->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this address?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('acc-avatar-input');
    const preview = document.getElementById('acc-avatar-preview');

    if (!input || !preview) {
        return;
    }

    input.addEventListener('change', function () {

        const file = this.files && this.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith('image/')) {
            this.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
        };

        reader.readAsDataURL(file);

    });

});

</script>

@endpush

@endsection