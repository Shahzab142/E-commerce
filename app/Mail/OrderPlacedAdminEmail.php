<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlacedAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New Order #{$this->order->order_number} Received",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.admin',
            with: [
                'order' => $this->order->load('items', 'user'),
                'customer' => $this->order->user,
            ],
        );
    }
}
