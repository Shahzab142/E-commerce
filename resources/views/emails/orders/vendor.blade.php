@component('components.email-layout')
    @slot('headerSubtitle')
        New Sale Notification
    @endslot

    <h2>New Order #{{ $order->order_number }}</h2>
    <p>Hello <strong>{{ $vendor->name }}</strong>, a customer purchased products from your store. Here are the details.</p>

    <div class="card">
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order #</span>
            <span class="info-value">#{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer</span>
            <span class="info-value">{{ $customerName }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date</span>
            <span class="info-value">{{ $order->placed_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Your Items</div>
        @forelse ($items as $item)
            <div class="info-row">
                <span class="info-label">{{ $item['product_name'] }} <span style="color: #94a3b8; font-size: 13px;">x{{ $item['quantity'] }}</span></span>
                <span class="info-value">${{ number_format($item['unit_price'], 2) }}</span>
            </div>
        @empty
            <p style="color: #94a3b8; margin: 0;">No items found.</p>
        @endforelse
    </div>

    <div class="card">
        <div class="section-title">Shipping Information</div>
        <p style="margin: 0; color: #1e293b; line-height: 1.6;">
            <strong>Ship to:</strong><br>
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_name }}<br>
            {{ $order->shipping_phone }}
        </p>
    </div>

    <p>If you have any questions about this order, contact the customer or our support team.</p>

    Thanks for your business!<br>
    <strong>{{ config('app.name', 'Shop Hub') }}</strong>
@endcomponent
