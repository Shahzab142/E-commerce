@component('components.email-layout')
    @slot('headerSubtitle')
        Profile Update Confirmation
    @endslot

    <h2>Your Profile Was Updated</h2>
    <p>Hello <strong>{{ $userName ?? 'there' }}</strong>, this is a confirmation that your profile was updated successfully.</p>

    <div class="card">
        <div class="section-title">Updated Fields</div>
        <div class="info-row">
            <span class="info-label">Changes</span>
            <span class="info-value">{{ $updatedFields ?? 'Profile information' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Updated At</span>
            <span class="info-value">{{ $updateTime ?? now()->format('F j, Y \\a\\t g:i A') }}</span>
        </div>
    </div>

    <p>If you did not make this change, please contact us immediately so we can secure your account.</p>

    Thanks,<br>
    <strong>{{ $appName ?? 'Shop Hub' }}</strong>
@endcomponent
