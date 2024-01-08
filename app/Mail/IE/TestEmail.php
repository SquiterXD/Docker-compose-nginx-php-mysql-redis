<?php

namespace App\Mail\IE;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('test@example.com', 'Test')
                    ->subject($this->data['subject'])
                    ->view('ie.commons.emails.template')
                    ->with([
                        'receiverNames' => $this->data['receiverNames'],
                        'title' =>  $this->data['title'],
                        'description' =>  $this->data['description'],
                        'reason' =>  $this->data['reason'],
                        'requestId' =>  $this->data['requestId'],
                    ]);
    }
}
