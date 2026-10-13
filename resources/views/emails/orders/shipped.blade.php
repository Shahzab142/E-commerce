@component('components.email-layout')
    @slot('headerSubtitle')
        Order Shipped
    @endslot

    <h2>Your Order Has Shipped!</h2>
    <p>Great news! Your order <strong>#{{ $order->order_number }}</strong> has been shipped and is on its way to you.</p>

    <div class="card">
        <div class="section-title">Shipping Details</div>
        <div class="info-row">
            <span class="info-label">Shipped On</span>
            <span class="info-value">{{ $shippedDate }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Shipping Method</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tracking Number</span>
            <span class="info-value">{{ $order->payment_reference ?? 'Not available yet' }}</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">What was in your order?</div>
        @foreach ($order->items as $item)
            <div class="info-row">
                <span class="info-label">{{ $item->product_name }} <span style="color: #94a3b8; font-size: 13px;">x{{ $item->quantity }}</span></span>
                <span class="info-value">${{ number_format($item->unit_price, 2) }}</span>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="section-title">Order Total</div>
        <div class="info-row" style="border-bottom: none; padding-top: 14px;">
            <span class="info-label" style="font-weight: 700; color: #1e293b;">Total</span>
            <span class="info-value" style="font-weight: 700; color: #4f46e5; font-size: 16px;">${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <a href="{{ url('/track-order') }}" class="btn">Track Your Order</a>

    <p>If you have any questions about your shipment, please contact our support team.</p>

    Thanks for your business!<br>
    <strong>{{ config('app.name', 'Shop Hub') }}</strong>
@endcomponent
