<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $title;
    public $content;
    public $buttonText;
    public $buttonUrl;

    public function __construct($subject, $title, $content, $buttonText = null, $buttonUrl = null)
    {
        $this->subject = $subject;
        $this->title = $title;
        $this->content = $content;
        $this->buttonText = $buttonText;
        $this->buttonUrl = $buttonUrl;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.marketing');
    }
}
