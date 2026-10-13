@extends('layouts.main')

@push('title')
    <title>Terms of Service - {{ config('app.name', 'Shop Hub') }}</title>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Legal</span>
                <h1 class="display-5 fw-bold mb-3">Terms of Service</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Please read these terms carefully before using our platform.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3">1. Acceptance of Terms</h3>
                        <p class="text-muted">By accessing or using our services, you agree to be bound by these Terms of Service and all applicable laws and regulations.</p>

                        <h3 class="fw-bold mt-4 mb-3">2. Use of the Platform</h3>
                        <p class="text-muted">You agree to use our platform only for lawful purposes and in a way that does not infringe the rights of others or restrict their use of the platform.</p>

                        <h3 class="fw-bold mt-4 mb-3">3. Product Information</h3>
                        <p class="text-muted">We strive to provide accurate product descriptions and pricing. However, we do not warrant that product descriptions or other content is accurate, complete, or error-free.</p>

                        <h3 class="fw-bold mt-4 mb-3">4. Orders & Payments</h3>
                        <p class="text-muted">All orders are subject to acceptance and availability. We reserve the right to refuse or cancel any order for any reason, including product availability or pricing errors.</p>

                        <h3 class="fw-bold mt-4 mb-3">5. Limitation of Liability</h3>
                        <p class="text-muted">We shall not be liable for any indirect, incidental, or consequential damages arising from the use of our platform or products.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
