<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Employee Portal" />
    @stack('title')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        :root {
            --bs-body-font-family: 'Inter', system-ui, -apple-system, sans-serif;
            --portal-primary: #28a745;
            --portal-navy: #1e3a8a;
            --portal-bg: #f8fafc;
        }
        body {
            font-family: var(--bs-body-font-family);
            background-color: var(--portal-bg);
            color: #334155;
            overflow-x: hidden;
        }
        .portal-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            height: 64px;
            z-index: 1030;
        }
        .portal-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            font-size: 1.25rem;
            color: #0f172a;
            text-decoration: none;
            width: 260px;
            padding: 0 1.25rem;
        }
        .portal-brand i {
            color: var(--portal-primary);
        }
        .search-wrapper {
            max-width: 400px;
            width: 100%;
        }
        .search-wrapper .form-control {
            border-radius: 9999px;
            background-color: #f1f5f9;
            border: 1px solid transparent;
            padding-left: 1rem;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .search-wrapper .form-control:focus {
            background-color: #ffffff;
            border-color: #cbd5e1;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.15);
        }
        .topbar-icon-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            background: #f1f5f9;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }
        .topbar-icon-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .topbar-icon-btn .badge-dot {
            position: absolute;
            top: 6px;
            right: 6px;
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #fff;
        }
        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 6px;
            border-radius: 9999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            color: #1e293b;
            font-weight: 500;
            font-size: 0.875rem;
        }
        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            background: #28a745;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        #layoutSidenav {
            display: flex;
            min-height: calc(100vh - 64px);
        }
        #layoutSidenav_nav {
            width: 270px;
            flex-shrink: 0;
            transition: margin-left 0.25s ease-in-out;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        #layoutSidenav_content {
            flex-grow: 1;
            min-width: 0;
            padding: 1.75rem;
            background-color: #f8fafc;
        }
        body.sb-sidenav-toggled #layoutSidenav_nav {
            margin-left: -270px;
        }
    </style>
    @stack('style')
</head>
<body>

    <!-- Top Navbar -->
    <nav class="portal-topbar navbar navbar-expand navbar-light px-3 d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('employee.dashboard') }}" class="portal-brand">
                <i class="bi bi-arrow-up-right-square-fill fs-4"></i>
                <span>KHYBER PRO</span>
            </a>
            <button class="btn btn-link text-secondary ms-2" id="sidebarToggle">
                <i class="fas fa-bars fs-5"></i>
            </button>
        </div>

        <div class="d-none d-md-block search-wrapper mx-3">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for something..." />
                <button class="btn btn-light border-0" type="button"><i class="fas fa-search text-muted"></i></button>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ url('/') }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 d-none d-lg-inline-flex align-items-center gap-1">
                <i class="bi bi-globe"></i> Visit Store
            </a>

            <a href="#" class="topbar-icon-btn">
                <i class="bi bi-bell"></i>
                <span class="badge-dot"></span>
            </a>
            
            <a href="#" class="topbar-icon-btn">
                <i class="bi bi-envelope"></i>
            </a>

            <div class="dropdown">
                <a class="user-dropdown-btn dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(auth()->user()->image && \Illuminate\Support\Facades\Storage::disk('public')->exists(auth()->user()->image))
                        <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Avatar" class="user-avatar">
                    @else
                        <div class="user-avatar">{{ substr(auth()->user()->name ?? 'E', 0, 1) }}</div>
                    @endif
                    <span class="d-none d-sm-inline">{{ auth()->user()->name ?? 'Employee' }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3 py-2 mt-2">
                    <li class="px-3 py-1">
                        <small class="text-muted d-block">Signed in as</small>
                        <strong>{{ auth()->user()->email }}</strong>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('employee.profile') }}"><i class="bi bi-person me-2"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="{{ route('employee.change-password') }}"><i class="bi bi-shield-lock me-2"></i> Change Password</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ url('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="layoutSidenav">
