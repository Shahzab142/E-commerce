@component('components.email-layout')
    @slot('headerSubtitle')
        Order Confirmation
    @endslot

    <h2>Order #{{ $order->order_number }} Confirmed</h2>
    <p>Thank you for your purchase! We’ve received your order and it is being processed.</p>

    <div class="card">
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order Number</span>
            <span class="info-value">#{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Order Date</span>
            <span class="info-value">{{ $order->placed_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Items Ordered</div>
        @forelse ($order->items as $item)
            <div class="info-row">
                <span class="info-label">{{ $item->product_name }} <span style="color: #94a3b8; font-size: 13px;">x{{ $item->quantity }}</span></span>
                <span class="info-value">${{ number_format($item->unit_price, 2) }}</span>
            </div>
        @empty
            <p style="color: #94a3b8; margin: 0;">No items found.</p>
        @endforelse
    </div>

    <div class="card">
        <div class="section-title">Totals</div>
        <div class="info-row">
            <span class="info-label">Subtotal</span>
            <span class="info-value">${{ number_format($order->subtotal, 2) }}</span>
        </div>
        @unless ($order->discount_total == 0)
            <div class="info-row">
                <span class="info-label">Discount</span>
                <span class="info-value" style="color: #10b981;">-${{ number_format($order->discount_total, 2) }}</span>
            </div>
        @endunless
        <div class="info-row">
            <span class="info-label">Shipping</span>
            <span class="info-value">${{ number_format($order->shipping_total, 2) }}</span>
        </div>
        <div class="info-row" style="border-bottom: none; padding-top: 14px;">
            <span class="info-label" style="font-weight: 700; color: #1e293b;">Total</span>
            <span class="info-value" style="font-weight: 700; color: #4f46e5; font-size: 16px;">${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Shipping Address</div>
        <p style="margin: 0; color: #1e293b; line-height: 1.6;">
            <strong>{{ $order->shipping_name }}</strong><br>
            {{ $order->shipping_phone }}<br>
            {{ $order->shipping_address }}
        </p>
    </div>

    <p>If you have any questions, please reply to this email or contact our support team.</p>

    Thanks for shopping with us!<br>
    <strong>{{ config('app.name', 'Shop Hub') }}</strong>
@endcomponent
