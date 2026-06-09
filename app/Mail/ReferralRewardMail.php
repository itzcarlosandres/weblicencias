<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class ReferralRewardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $referrer;
    public $referredUser;
    public $points;

    /**
     * Create a new message instance.
     */
    public function __construct(User $referrer, User $referredUser, int $points)
    {
        $this->referrer = $referrer;
        $this->referredUser = $referredUser;
        $this->points = $points;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Ganaste ' . number_format($this->points) . ' TodoPuntos por referir a un amigo!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.referral_reward',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
