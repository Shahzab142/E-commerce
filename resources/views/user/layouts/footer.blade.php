<footer class="py-3 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
                Copyright &copy; {{ date('Y') }} {{ config('app.name', 'Shop Hub') }}. All rights reserved.
            </div>
            <div>
                <a href="{{ route('terms') }}" class="text-decoration-none text-muted me-2">Terms</a>
                <a href="{{ route('privacy') }}" class="text-decoration-none text-muted">Privacy</a>
            </div>
        </div>
    </div>
</footer>
