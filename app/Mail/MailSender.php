<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSender extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $data;
    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$data,$template)
    {
        $this->subject = $subject;
        $this->data = $data;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->subject;
        $data = $this->data;
        $template = $this->template;

        return $this->subject($subject)->view($template, compact('data'));
    }
}
