@component('components.email-layout')
    @slot('headerSubtitle')
        New Order Received
    @endslot

    <h2>New Order #{{ $order->order_number }}</h2>
    <p>A new order has been placed on <strong>{{ config('app.name', 'Shop Hub') }}</strong>. Here are the details:</p>

    <div class="card">
        <div class="section-title">Order Details</div>
        <div class="info-row">
            <span class="info-label">Order #</span>
            <span class="info-value">#{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Customer</span>
            <span class="info-value">{{ $customer->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $customer->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Date</span>
            <span class="info-value">{{ $order->placed_at?->format('M d, Y') ?? $order->created_at->format('M d, Y') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment Method</span>
            <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
        </div>
    </div>

    <div class="card">
        <div class="section-title">Order Totals</div>
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
        <div class="section-title">Items</div>
        @forelse ($order->items as $item)
            <div class="info-row">
                <span class="info-label">{{ $item->product_name }} <span style="color: #94a3b8; font-size: 13px;">x{{ $item->quantity }}</span></span>
                <span class="info-value">${{ number_format($item->unit_price, 2) }}</span>
            </div>
        @empty
            <p style="color: #94a3b8; margin: 0;">No items found.</p>
        @endforelse
    </div>

    {{ config('app.name', 'Shop Hub') }}
@endcomponent
