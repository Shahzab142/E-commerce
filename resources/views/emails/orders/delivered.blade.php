@component('components.email-layout')
    @slot('headerSubtitle')
        Delivery Confirmation
    @endslot

    <h2>Your Order Has Been Delivered!</h2>
    <p>Congratulations! Your order <strong>#{{ $order->order_number }}</strong> has been successfully delivered.</p>

    <div class="card">
        <div class="section-title">Delivery Details</div>
        <div class="info-row">
            <span class="info-label">Delivered On</span>
            <span class="info-value">{{ $deliveryDate }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Shipping Method</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->shipping_method)) }}</span>
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

    <p>We hope you're happy with your purchase! If there are any issues with your order, please contact us right away so we can make it right.</p>

    <a href="{{ url('/orders') }}" class="btn">View Your Orders</a>

    Thank you for choosing us!<br>
    <strong>{{ config('app.name', 'Shop Hub') }}</strong>
@endcomponent
