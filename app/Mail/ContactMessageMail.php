<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageText;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $messageText)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->messageText = $messageText;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nuevo mensaje de contacto: ' . $this->subject)
                    ->replyTo($this->email, $this->name)
                    ->view('emails.contact_message');
    }
}
