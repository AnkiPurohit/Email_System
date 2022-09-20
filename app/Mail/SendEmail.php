<?php

namespace App\Mail;

use Mail;
use Swift_SmtpTransport;
use Swift_Mailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
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
        $address = $this->data['from_email'];
        $subject = $this->data['subject'];
        $name = $this->data['from_name'];

        return $this->view('emails.template')
            ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['body' => $this->data['body']]);
    }
}
