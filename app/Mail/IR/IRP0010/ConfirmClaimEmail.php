<?php

namespace App\Mail\IR\IRP0010;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmClaimEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $header, $sender, $defualtDesc, $cc)
    {
        $this->cc = $cc;
        $this->data = $data;
        $this->header = $header;
        $this->sender = $sender;
        $this->defualtDesc = $defualtDesc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@mcrconsult.com', 'MERCURY')
                    ->subject('รายละเอียดการแจ้งเหตุการเคลมประกันภัย')
                    ->cc($this->cc)
                    ->view('ir.claim-insurance.emails.template')
                    ->with([
                        'header' => $this->header,
                        'defualtDesc' => $this->defualtDesc,
                        'subject' => $this->data['subject'],
                        'receiverNames' => $this->data['receiverNames'],
                        'ccReceiverNames' => $this->data['ccReceiverName'],
                    ]);
    }
}
