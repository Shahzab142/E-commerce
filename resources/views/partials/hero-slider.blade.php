{{-- Hero Carousel --}}
@php
    $sliderDir = public_path('slider');
    $sliderImages = [];
    if (file_exists($sliderDir)) {
        $files = array_diff(scandir($sliderDir), array('.', '..'));
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) !== '') {
                $sliderImages[] = 'slider/' . $file;
            }
        }
    }
@endphp

@if(count($sliderImages) > 0)
<div id="carouselExampleDark" class="carousel slide carousel-fade mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        @foreach($sliderImages as $index => $image)
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>

    <div class="carousel-inner">
        @foreach($sliderImages as $index => $image)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-bs-interval="2000">
                <img src="{{ asset($image) }}" class="d-block w-100" style="object-fit: cover;" alt="Promo">
            </div>
        @endforeach
    </div>

    @if(count($sliderImages) > 1)
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    @endif
</div>
@endif
