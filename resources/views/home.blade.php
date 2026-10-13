@extends('layouts.main')

@push('title') <title>{{ config('app.name', 'Shop Hub') }} | Quality Products Online</title>
@endpush

@section('meta_description', 'Shop quality electronics, fashion, furniture, groceries, and more from trusted sellers at ' . config('app.name', 'Shop Hub') . '.')

@section('og_title', config('app.name', 'Shop Hub') . ' | Quality Products Online')

@section('content')

{{-- Hero Carousel --}}
@include('partials.hero-slider')


{{-- Stats Band --}}
<section class="py-4 bg-white border-bottom">

    <div class="container">

        <div class="row g-4 text-center">

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-center gap-3">

                    <div class="text-primary fs-1">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="text-start">
                        <div class="fw-bold fs-5">
                            {{ $stats['productCount'] }}+
                        </div>

                        <div class="text-muted small">
                            Products
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-center gap-3">

                    <div class="text-primary fs-1">
                        <i class="bi bi-bag-check"></i>
                    </div>

                    <div class="text-start">
                        <div class="fw-bold fs-5">
                            {{ $stats['itemsSold'] }}+
                        </div>

                        <div class="text-muted small">
                            Items Sold
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>

</section>


{{-- Top Deals --}}
@include('layouts.top-deals-product')


{{-- Best Sellers --}}
@include('layouts.best-electronics')


{{-- Popular Categories --}}
@include('layouts.popular-category')


{{-- Customer Reviews --}}
@if ($reviews->isNotEmpty())

    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="shop-eyebrow">
                    Testimonials
                </span>

                <h2 class="shop-section-title">
                    What Our Customers Say
                </h2>

                <p class="shop-section-sub">
                    Real reviews from real shoppers
                </p>

            </div>

            <div class="row g-4">

                @foreach ($reviews as $review)

                    <div class="col-lg-3 col-md-6">

                        <div class="card shop-review-card h-100 border-0 shadow-sm">

                            <div class="card-body p-4">

                                <div class="text-warning mb-2">

                                    @for ($i = 1; $i <= 5; $i++)

                                        <i class="bi {{ $i <= ($review->rating ?? 5) ? 'bi-star-fill' : 'bi-star' }}"></i>

                                    @endfor

                                </div>

                                <p class="text-secondary mb-3">
                                    "{{ $review->comment ?? 'Great product!' }}"
                                </p>

                                <div class="d-flex align-items-center gap-2 mt-auto">

                                    @if ($review->user?->image)

                                        <img
                                            src="{{ asset('storage/' . $review->user->image) }}"
                                            alt="{{ $review->user->name }}"
                                            class="rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover;"
                                        >

                                    @else

                                        <div class="shop-avatar">
                                            {{ substr($review->user->name ?? 'U', 0, 1) }}
                                        </div>

                                    @endif

                                    <div>

                                        <div class="fw-semibold small">
                                            {{ $review->user->name ?? 'Customer' }}
                                        </div>

                                        <small class="text-muted">
                                            {{ $review->created_at?->format('M j, Y') ?? '' }}
                                        </small>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

@endif

{{-- Recently Viewed Products --}}
@include('layouts.recently-view')


@endsection
