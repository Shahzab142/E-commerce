<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class NewsletterSubscriberMail extends Mailable
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to ' . config('app.name') . ' Newsletter',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newsletter-subscriber',
            with: [
                'email' => $this->email,
                'appName' => config('app.name'),
            ],
        );
    }
}
