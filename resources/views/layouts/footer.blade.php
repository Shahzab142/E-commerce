@php
    $role = auth()->check() ? auth()->user()->role : 'guest';

    $socialLinks = [
        ['icon' => 'bi bi-linkedin', 'name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/muhammad-aaqib-b9a5a0315'],
        ['icon' => 'bi bi-github', 'name' => 'GitHub', 'url' => 'https://github.com/muhammad00-hub'],
        ['icon' => 'svg-fiverr', 'name' => 'Fiverr', 'url' => 'https://www.fiverr.com/aaqib66?public_mode=true'],
        ['icon' => 'svg-upwork', 'name' => 'Upwork', 'url' => 'https://www.upwork.com/freelancers/~01e7ac036d82e9674f?viewMode=1'],
        ['icon' => 'bi bi-person-badge', 'name' => 'Freelancer', 'url' => 'https://www.freelancer.com/u/muhammadk067'],
    ];

    $showBusinessDetails = $role === 'admin';
    $adminDetails = null;
    $vendorDetails = null;

    if ($showBusinessDetails && auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $adminDetails = $user->adminDetail;
        }
    }
@endphp

<footer class="shop-footer pt-5 pb-3">
    <div class="container">
        <div class="row gy-4">

            {{-- Brand & About --}}
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('home') }}" class="shop-logo text-white text-decoration-none mb-3 d-inline-flex">
                    @include('partials.site-logo')
                    {{ config('app.name', 'Shop Hub') }}
                </a>

                @if ($showBusinessDetails && $adminDetails)
                    <div class="mt-3 p-3 bg-white bg-opacity-10 rounded">
                        <h6 class="fw-bold text-white mb-2">Admin Contact</h6>
                        @if ($adminDetails->country || $adminDetails->city)
                            <p class="text-secondary small mb-1">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ implode(', ', array_filter([$adminDetails->city, $adminDetails->country, $adminDetails->postal_code])) }}
                            </p>
                        @endif
                        @if ($adminDetails->address)
                            <p class="text-secondary small mb-1">{{ Str::limit($adminDetails->address, 80) }}</p>
                        @endif
                        @if ($adminDetails->easypaisa_number || $adminDetails->jazzcash_number || $adminDetails->bank_name)
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-credit-card me-1"></i>
                                Multiple payment methods available
                            </p>
                        @endif
                    </div>
                @elseif ($showBusinessDetails && $vendorDetails)
                    <div class="mt-3 p-3 bg-white bg-opacity-10 rounded">
                        <h6 class="fw-bold text-white mb-2">Vendor Contact</h6>
                        @if ($vendorDetails->business_address)
                            <p class="text-secondary small mb-1">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ Str::limit($vendorDetails->business_address, 80) }}
                            </p>
                        @endif
                        @if ($vendorDetails->business_phone)
                            <p class="text-secondary small mb-1">
                                <i class="bi bi-telephone me-1"></i>
                                {{ $vendorDetails->business_phone }}
                            </p>
                        @endif
                        @if ($vendorDetails->easypaisa_number || $vendorDetails->jazzcash_number || $vendorDetails->account_number)
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-wallet2 me-1"></i>
                                Payment methods configured
                            </p>
                        @endif
                    </div>
                @else
                    <p class="text-secondary mt-3">
                        Internal portal for Khyber Pro employees. Browse products, manage your commissions, and track reservations.
                    </p>
                @endif

                {{-- Social Links --}}
                <div class="d-flex gap-2 mt-3 flex-wrap">
                    @foreach ($socialLinks as $link)
                        @if ($link['icon'] === 'svg-fiverr')
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle p-2" title="{{ $link['name'] }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.37 0 0 5.37 0 12s5.37 12 12 12 12-5.37 12-12S18.63 0 12 0zm0 2.13c1.47 0 2.66 1.19 2.66 2.66S13.47 7.45 12 7.45 9.34 6.26 9.34 4.79 10.53 2.13 12 2.13zM7.2 6.63v3.14h2.05v1.33H7.2v3.14h2.64v1.33H4.59V6.63h2.61zm5.27 0v8.74h2.05v-3.27h1.91v-1.33h-1.91V8.73h2.05V6.63H12.5zm3.9 0v8.74h2.05v-3.27h1.91v-1.33h-1.91V8.73h2.05V6.63h-3.1z"/></svg>
                            </a>
                        @elseif ($link['icon'] === 'svg-upwork')
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle p-2" title="{{ $link['name'] }}">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M.989 8.064c-.271.635-.521 1.283-.747 1.943L0 12.99l.242.983c.226.66.476 1.308.747 1.943l.697.006c.635-1.049 1.316-2.057 2.037-3.023.72-.966 1.493-1.887 2.314-2.762-.821.875-1.594 1.796-2.314 2.762-.721.966-1.402 1.974-2.037 3.023zm6.992 4.833c.721.966 1.493 1.887 2.314 2.762.821-.875 1.594-1.796 2.314-2.762.721-.966 1.402-1.974 2.037-3.023l-.697-.006c-.271-.635-.521-1.283-.747-1.943L8.06 7.009l-.242-.983C7.592 5.366 7.342 4.718 7.072 4.08l-.697-.006c-.635 1.049-1.316 2.057-2.037 3.023-.72.966-1.493 1.887-2.314 2.762z"/></svg>
                            </a>
                        @else
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener" class="btn btn-outline-light btn-sm rounded-circle p-2" title="{{ $link['name'] }}">
                                <i class="{{ $link['icon'] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="text-white fw-semibold mb-3">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Dashboard</a></li>
                    <li class="mb-2"><a href="{{ route('about') }}" class="text-secondary text-decoration-none">About Us</a></li>
                    <li class="mb-2"><a href="{{ route('contact') }}" class="text-secondary text-decoration-none">Contact Admins</a></li>
                    <li class="mb-2"><a href="{{ route('faqs') }}" class="text-secondary text-decoration-none">FAQs</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div class="col-lg-2 col-md-6 col-6">
                <h6 class="text-white fw-semibold mb-3">Legal</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('terms') }}" class="text-secondary text-decoration-none">Terms of Service</a></li>
                    <li class="mb-2"><a href="{{ route('privacy') }}" class="text-secondary text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>



        <hr class="border-secondary my-4">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
            <p class="text-secondary mb-0 small">
                &copy; {{ date('Y') }} Khyber Pro. All rights reserved.
            </p>
            <div class="d-flex gap-3">
                <span class="text-secondary small">Developed by <span class="fw-bold text-white">MUHAMMAD AAQIB</span></span>
                <a href="#" class="text-secondary text-decoration-none small">Privacy Policy</a>
                <a href="#" class="text-secondary text-decoration-none small">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
