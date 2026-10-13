<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>

<body class="bg-light min-vh-100">
    <div class="container-fluid g-0">
        <div class="row g-0">
            <nav id="sidebar" class="col-lg-3 col xl-2 col-xxl-2 d-none d-lg-block bg-white border-end vh-100 position-fixed top-0">
                <div class="d-flex flex-column vh-100 p-3">
                    <a href="{{ route('home') }}" class="text-decoration-none mb-4" wire:navigate>
                    @php
                        $sidebarLogoUrl = null;
                        foreach (['png', 'svg', 'jpg', 'jpeg', 'webp'] as $sidebarLogoExt) {
                            if (is_file(public_path('assets/images/logo.' . $sidebarLogoExt))) {
                                $sidebarLogoUrl = asset('assets/images/logo.' . $sidebarLogoExt);
                                break;
                            }
                        }
                    @endphp
                    <span class="navbar-brand mb-0 h4 fw-bold text-primary d-flex align-items-center gap-2">
                        @if ($sidebarLogoUrl)
                            <img src="{{ $sidebarLogoUrl }}" alt="{{ config('app.name', 'E-Commerce') }}" style="height: 28px; width: auto; object-fit: contain;">
                        @endif
                        {{ config('app.name', 'E-Commerce') }}
                    </span>
                </a>

                    <ul class="nav nav-pills flex-column mb-auto" role="tablist">
                        <li class="mb-1">
                            <a href="{{ route('dashboard') }}" wire:navigate
                                class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-dark' }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-pills flex-column mt-auto mb-3" role="tablist">
                        <li class="mb-1">
                            <a href="https://github.com/laravel/livewire-starter-kit" target="_blank"
                                class="nav-link text-dark">
                                <i class="bi bi-folder-git-2 me-2"></i> Repository
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="https://laravel.com/docs/starter-kits" target="_blank"
                                class="nav-link text-dark">
                                <i class="bi bi-book-open-text me-2"></i> Documentation
                            </a>
                        </li>
                    </ul>

                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width: 36px; height: 36px;">
                                <span class="text-primary fw-bold small">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            </div>
                            <span class="small fw-medium">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down ms-2 small"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('settings.profile') }}" wire:navigate>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item w-100 text-start">Log Out</button>
                            </form>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="col-lg-3 col xl d-lg-none d-xl-block">
                <header class="bg-white border-bottom px-3 px-md-4 py-2 d-flex align-items-center justify-content-between">
                    <button class="btn btn-outline-secondary d-lg-none" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                        <i class="bi bi-list"></i>
                    </button>
                </header>
            </div>

            <div class="col-lg-12 col-xl">
                <main class="py-4 px-3 px-md-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">{{ config('app.name', 'E-Commerce') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="nav nav-pills flex-column p-2">
                <li class="mb-1">
                    <a href="{{ route('dashboard') }}" class="nav-link" wire:navigate>Dashboard</a>
                </li>
                <li class="mb-1">
                    <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="nav-link">Repository</a>
                </li>
                <li class="mb-1">
                    <a href="https://laravel.com/docs/starter-kits" target="_blank" class="nav-link">Documentation</a>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireScript
    @stack('scripts')
</body>
</html>
