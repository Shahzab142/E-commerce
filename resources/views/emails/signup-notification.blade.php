@component('components.email-layout')
    @slot('headerSubtitle')
        New Registration Alert
    @endslot

    <h2>New Registration Received</h2>
    <p>Hello Admin, a new account has just been created on <strong>{{ $appName ?? 'Shop Hub' }}</strong>. Here are the details:</p>

    <div class="card">
        <div class="info-row">
            <span class="info-label">Name</span>
            <span class="info-value">{{ $userName ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $userEmail ?? 'N/A' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value"><span class="badge">{{ $roleLabel ?? 'User' }}</span></span>
        </div>
        <div class="info-row">
            <span class="info-label">Registered</span>
            <span class="info-value">{{ $registrationTime ?? 'Recently' }}</span>
        </div>
    </div>

    <p style="margin-top: 22px;">You can review this account from your admin dashboard.</p>

    <a href="{{ url('/admin') }}" class="btn">Go to Admin Dashboard</a>

    Thanks,<br>
    <strong>{{ $appName ?? 'Shop Hub' }}</strong>
@endcomponent
