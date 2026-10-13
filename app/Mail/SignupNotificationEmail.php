<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupNotificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $roleLabel;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->roleLabel = match ($user->role) {
            User::ROLE_ADMIN => 'Administrator',
            User::ROLE_VENDOR => 'Vendor/Seller',
            default => 'Customer',
        };
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New {$this->roleLabel} Registration - " . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.signup-notification',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'roleLabel' => $this->roleLabel,
                'registrationTime' => $this->user->created_at->format('F j, Y \a\t g:i A'),
                'appName' => config('app.name'),
            ],
        );
    }
}
