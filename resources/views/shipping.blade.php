@extends('layouts.main')

@push('title')
    <title>Shipping Information - {{ config('app.name', 'Shop Hub') }}</title>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <span class="shop-eyebrow">Delivery</span>
                <h1 class="display-5 fw-bold mb-3">Shipping Information</h1>
                <p class="lead text-muted mx-auto" style="max-width: 600px;">Fast, reliable delivery to your doorstep. Here's everything you need to know about our shipping process.</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Standard Shipping</h5>
                    <p class="text-muted small">3-5 business days</p>
                    <p class="fw-bold text-primary">Free on orders over $50</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Express Shipping</h5>
                    <p class="text-muted small">1-2 business days</p>
                    <p class="fw-bold text-primary">$9.99 flat rate</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center p-4 shop-cat-card">
                    <div class="shop-cat-card__icon mx-auto">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h5 class="fw-bold mt-3">Same-Day Delivery</h5>
                    <p class="text-muted small">Select cities only</p>
                    <p class="fw-bold text-primary">$14.99 flat rate</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-3">Shipping Policy</h3>
                        <p class="text-muted">We ship to most locations nationwide. Orders placed before 2 PM on business days are usually processed the same day. Once shipped, you will receive a tracking link via email and SMS. We are not responsible for delays caused by customs or local courier services.</p>
                        <h3 class="fw-bold mt-4 mb-3">International Shipping</h3>
                        <p class="text-muted">International shipping is available for select countries. Delivery times and fees vary by destination. Import duties and taxes are the responsibility of the customer.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
