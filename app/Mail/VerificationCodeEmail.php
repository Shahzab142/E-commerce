<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeEmail extends Mailable
{
    use Queueable,SerializesModels;

    public string $code;
    public string $expiresAt;
    public string $context;

    /**
     * @param string $code       The plain 6-digit code.
     * @param string $expiresAt  Human-readable expiry time.
     * @param string $context    'signup' or 'reset'.
     */
    public function __construct(string $code, string $expiresAt, string $context = 'reset')
    {
        $this->code = $code;
        $this->expiresAt = $expiresAt;
        $this->context = $context;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = match ($this->context) {
            'signup' => 'Verify Your Email - ' . config('app.name'),
            'login' => 'Verify Your Email - ' . config('app.name'),
            default => 'Your Verification Code - ' . config('app.name'),
        };

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.verification-code',
            text: 'emails.verification-code-text',
            with: [
                'code' => $this->code,
                'expiresAt' => $this->expiresAt,
                'context' => $this->context,
                'appName' => config('app.name'),
            ],
        );
    }
}
