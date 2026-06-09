<?php

namespace App\Mail;

use App\Models\AbandonedCart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Setting;

class AbandonedCartMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cart;
    public $appName;
    public $primaryColor;

    /**
     * Create a new message instance.
     */
    public function __construct(AbandonedCart $cart)
    {
        $this->cart = $cart;
        $this->appName = Setting::get('meta_title', config('app.name', 'TodoKeys'));
        $this->primaryColor = Setting::get('primary_color', '#3b82f6');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Olvidaste algo en tu carrito... 👀',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.abandoned-cart',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
