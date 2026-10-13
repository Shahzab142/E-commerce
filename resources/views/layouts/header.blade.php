{{-- ================================================================
     MAIN NAVBAR
================================================================ --}}

<style>
    .daraz-top-bar {
        background-color: #f85606;
        padding: 4px 0;
    }
    .daraz-top-bar a {
        color: white;
        text-decoration: none;
        font-size: 12px;
        margin-left: 20px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .daraz-top-bar a:hover {
        color: #ffe0d1;
    }
    .top-auth-btn {
        background-color: white;
        color: #f85606 !important;
        padding: 3px 14px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 13px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        transition: all 0.2s ease-in-out;
        margin-left: 25px !important;
    }
    .top-auth-btn:hover {
        background-color: #fff4ed;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .daraz-header {
        background-color: #f85606;
        padding: 10px 0 15px 0;
    }
    .daraz-logo-text {
        color: white;
        font-size: 28px;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .daraz-search-form {
        display: flex;
        width: 100%;
        max-width: 650px;
        background: white;
        border-radius: 2px;
        overflow: hidden;
    }
    .daraz-search-input {
        border: none;
        padding: 10px 15px;
        width: 100%;
        outline: none;
    }
    .daraz-search-btn {
        background: #ffe0d1;
        border: none;
        padding: 0 20px;
        color: #f85606;
        cursor: pointer;
    }
    .daraz-search-btn:hover {
        background: #ffccb3;
    }
    .daraz-cart-icon {
        color: white;
        font-size: 24px;
        text-decoration: none;
        position: relative;
    }
    .daraz-cart-badge {
        position: absolute;
        top: -5px;
        right: -10px;
        background: white;
        color: #f85606;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: bold;
    }
</style>

<!-- Announcement Bar -->
<div class="daraz-top-bar d-none d-md-block">
    <div class="container d-flex justify-content-end">
        <a href="#">KHYBER PRO EMPLOYEE PORTAL</a>
        <a href="#">HELP & SUPPORT</a>
        @guest
            <a href="{{ route('login') }}" class="top-auth-btn"><i class="bi bi-box-arrow-in-right me-1"></i> LOGIN</a>
            <a href="{{ route('register') }}" class="top-auth-btn"><i class="bi bi-person-plus-fill me-1"></i> SIGN UP</a>
        @else
            <a href="{{ route(auth()->user()->dashboardRoute()) }}" class="top-auth-btn"><i class="bi bi-speedometer2 me-1"></i> DASHBOARD</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="top-auth-btn"><i class="bi bi-box-arrow-right me-1"></i> LOGOUT</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        @endguest
    </div>
</div>

{{-- Main Header (Daraz Style) --}}
<nav class="daraz-header shop-header">
    <div class="container">
        <div class="shop-header-inner d-flex align-items-center justify-content-between">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-decoration-none d-flex align-items-center me-4">
                @include('partials.site-logo')
            </a>

            {{-- Search --}}
            <div class="flex-grow-1 mx-4 d-none d-lg-block position-relative">
                <form class="daraz-search-form" action="{{ route('search') }}" method="GET" id="searchForm">
                    <input type="search" class="daraz-search-input" name="q" placeholder="Search Product"
                        aria-label="Search" value="{{ request('q') }}" id="searchInput" autocomplete="off" required>
                    <button type="submit" class="daraz-search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                {{-- Autocomplete Dropdown --}}
                <div class="search-autocomplete-dropdown" id="searchDropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; z-index: 1000; border-radius: 0 0 4px 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-top: 2px;">
                    <div class="search-autocomplete-products p-2" id="searchProducts"></div>
                    <div class="search-autocomplete-categories p-2" id="searchCategories"></div>
                </div>
            </div>
            
            {{-- Right Actions --}}
            <div class="d-flex align-items-center gap-4">
                {{-- Mobile Search Toggle --}}
                <button class="btn btn-link text-white d-lg-none p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileSearch">
                    <i class="bi bi-search fs-4"></i>
                </button>

{{-- Cart removed for Employee Portal --}}
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="collapse d-lg-none mt-3" id="mobileSearch">
            <form class="daraz-search-form w-100" action="{{ route('search') }}" method="GET">
                <input type="search" class="daraz-search-input" name="q" placeholder="Search Product"
                    value="{{ request('q') }}" required>
                <button type="submit" class="daraz-search-btn">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- Category Rail with Mega Menu --}}
<nav class="shop-cat-rail">
    <div class="container">
        <ul class="nav">
            @php
                $categories = \App\Models\AdminCategory::query()
                    ->where('status', 'published')
                    ->withCount('products')
                    ->orderBy('name')
                    ->get();
            @endphp
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shop') }}">
                    <i class="bi bi-grid me-1"></i>All Products
                </a>
            </li>
            @forelse ($categories->take(10) as $category)
                <li class="nav-item mega-menu-item">
                    <a class="nav-link" href="{{ url('category/' . $category->slug) }}">
                        {{ $category->name }}
                        @if($category->products_count > 0)
                            <span class="badge bg-light text-dark ms-1">{{ $category->products_count }}</span>
                        @endif
                    </a>
                    @if($category->children && $category->children->count() > 0)
                        <div class="mega-menu-dropdown">
                            <div class="row g-4 p-4">
                                @foreach($category->children->take(6) as $child)
                                    <div class="col-4">
                                        <a href="{{ url('category/' . $child->slug) }}" class="mega-menu-link">
                                            {{ $child->name }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </li>
            @empty
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">All Products</a>
                </li>
            @endforelse
            @if($categories->count() > 10)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">More</a>
                    <ul class="dropdown-menu">
                        @foreach($categories->skip(10) as $category)
                            <li><a class="dropdown-item" href="{{ url('category/' . $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</nav>
