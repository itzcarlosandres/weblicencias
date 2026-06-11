<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WishlistPriceDropMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $product;
    public $oldPrice;
    public $newPrice;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $product, $oldPrice, $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Un producto en tu lista de deseos bajó de precio! 🔥',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.wishlist.price-drop',
            with: [
                'productName' => $this->product->name,
                'oldPrice' => $this->oldPrice,
                'newPrice' => $this->newPrice,
                'url' => route('products.show', $this->product->slug),
            ]
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
