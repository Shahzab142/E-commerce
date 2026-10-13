<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>
            @hasSection('title')
                @yield('title') - {{ config('app.name', 'Shop Hub') }}
            @else
                {{ config('app.name', 'Shop Hub') }}
            @endif
        </title>
        @if (is_file(public_path('assets/images/logo.png')))
            <link rel="icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
        @endif
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="{{ url('dashboard/css/styles.css') }}" rel="stylesheet" />
        <link href="{{ url('assets/css/dashboard.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        @stack('styles')
    </head>
    <body class="sb-nav-fixed">
        @include('user.layouts.header')
        <div id="layoutSidenav">
            @include('user.layouts.sidebar')
            <div id="layoutSidenav_content">
                <main>
                    @yield('content')
                </main>
                @include('user.layouts.footer')
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ url('dashboard/js/scripts.js') }}"></script>
        @stack('scripts')
    </body>
</html>
