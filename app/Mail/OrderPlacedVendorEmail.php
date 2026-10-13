<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedVendorEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, object{product_name:string,quantity:int,unit_price:float,subtotal:float}>  $vendorItems
     */
    public function __construct(
        public Order $order,
        public User $vendor,
        public array $vendorItems,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Order #{$this->order->order_number} Contains Your Products",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.vendor',
            with: [
                'order' => $this->order,
                'vendor' => $this->vendor,
                'items' => $this->vendorItems,
                'customerName' => $this->order->shipping_name,
            ],
        );
    }
}
