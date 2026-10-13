<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class OrderShippedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Order #{$this->order->order_number} Shipped",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.shipped',
            with: [
                'order' => $this->order,
                'shippedDate' => Carbon::parse($this->order->updated_at)->format('M d, Y'),
            ],
        );
    }
}
