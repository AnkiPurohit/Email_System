<?php

namespace App\Jobs;

use App\Mail\SendEmail as AppSendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Swift_SmtpTransport;
use Swift_Mailer;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emailData;

    protected const MAX_RETRY_BEFORE_SWITCH = 3;
    protected const MAX_RETRY_BEFORE_FAIL = 6;

    public $tries = self::MAX_RETRY_BEFORE_FAIL;

    protected $retries;

    protected $defaultMailConfig;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->defaultMailConfig = Mail::getSwiftMailer();
        $data['from_name'] = $this->emailData['from_name'];
        $data['from_email'] = $this->emailData['from_email'];
        $data['subject'] = $this->emailData['subject'];
        $data['body'] = $this->emailData['body'];
        try {
            \Mail::to($this->emailData['email'])->send(new AppSendEmail($data));
        } catch (\Exception $e) {
            $backup = Mail::getSwiftMailer();
            if ($this->attempts() == self::MAX_RETRY_BEFORE_SWITCH) {
                $transport = new Swift_SmtpTransport(
                    Config('mail.mailers.smtp.host'),
                    Config('mail.mailers.smtp.port'),
                    Config('mail.mailers.smtp.encryption'),
                );
                $transport->setUsername(Config('mail.mailers.smtp.username'));
                $transport->setPassword(Config('mail.mailers.smtp.password'));
                $smtpMailer = new Swift_Mailer($transport);
                \Mail::setSwiftMailer($smtpMailer);
            }
            if ($this->attempts() == self::MAX_RETRY_BEFORE_FAIL) {
                Mail::setSwiftMailer($backup);
                throw $e;
            }
            $this->release(2);
        }
    }
}
