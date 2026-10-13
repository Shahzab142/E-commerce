<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProfileUpdatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $updatedFields;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $updatedFields = 'Profile information')
    {
        $this->user = $user;
        $this->updatedFields = $updatedFields;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Profile Updated - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.profile-updated',
            with: [
                'userName' => $this->user->name,
                'userEmail' => $this->user->email,
                'updatedFields' => $this->updatedFields,
                'updateTime' => now()->format('F j, Y \a\t g:i A'),
                'appName' => config('app.name'),
            ],
        );
    }
}
