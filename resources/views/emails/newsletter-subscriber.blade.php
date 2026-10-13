@component('components.email-layout')
    @slot('headerSubtitle')
        Welcome Aboard
    @endslot

    <h2>Thanks for Subscribing!</h2>
    <p>You’re now part of the <strong>{{ $appName ?? 'Shop Hub' }}</strong> community. Get ready for exclusive deals, new arrivals, and special discounts delivered straight to your inbox.</p>

    <div class="card">
        <div class="info-row">
            <span class="info-label">Subscribed Email</span>
            <span class="info-value">{{ $email }}</span>
        </div>
    </div>

    <a href="{{ route('shop') }}" class="btn">Start Shopping</a>

    <p>Stay tuned for amazing offers!</p>

    Thanks,<br>
    <strong>{{ $appName ?? 'Shop Hub' }}</strong>
@endcomponent
