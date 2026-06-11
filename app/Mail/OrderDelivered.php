<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderDelivered extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Tu orden {$this->order->order_number} ha sido entregada - TodoKeys",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-delivered',
            with: [
                'order' => $this->order,
                'items' => $this->order->items()->with('license')->get(),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
