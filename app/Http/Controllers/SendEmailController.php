<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendEmailRequest;
use App\Repositories\EmailTemplateRepository;

class SendEmailController extends Controller
{
    /**
     * @var EmailTemplateRepository
     */
    protected $templateRepository;

    /**
     * SendEmailController constructor.
     *
     * @param EmailTemplateRepository $repository
     */

    public function __construct(EmailTemplateRepository $repository)
    {
        $this->templateRepository = $repository;
    }

    /**
     * Send email using new request.
     * 
     * @param  SendEmailRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function send(SendEmailRequest $request)
    {
        $this->templateRepository->sendBulkEmails($request);
        return json_encode(['message' => 'Emails Job initiated']);
    }
}
