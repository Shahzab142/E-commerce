<div class="row g-0">
    <div class="col-md-3 col-lg-2 pb-4-md pb-0">
        <div class="list-group list-group-flush" role="tablist">
            <a href="{{ route('settings.profile') }}" wire:navigate
                class="list-group-item list-group-item-action border-0 py-2" role="tab">
                Profile
            </a>
            <a href="{{ route('settings.password') }}" wire:navigate
                class="list-group-item list-group-item-action border-0 py-2" role="tab">
                Password
            </a>
            <a href="{{ route('settings.appearance') }}" wire:navigate
                class="list-group-item list-group-item-action border-0 py-2" role="tab">
                Appearance
            </a>
        </div>
    </div>

    <div class="col-md-9 col-lg-10">
        <h2 class="h5 fw-bold mb-1">{{ $heading ?? '' }}</h2>
        <p class="text-muted small mb-4">{{ $subheading ?? '' }}</p>

        <div class="w-100">
            {{ $slot }}
        </div>
    </div>
</div>
