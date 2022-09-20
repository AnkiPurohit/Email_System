<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EmailTemplateRepository;
use App\Entities\EmailTemplate;
use App\Validators\EmailTemplateValidator;
// use App\Mail\SendEmail as AppSendEmail;


/**
 * Class EmailTemplateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EmailTemplateRepositoryEloquent extends BaseRepository implements EmailTemplateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailTemplate::class;
    }

    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {

        return EmailTemplateValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function sendBulkEmails($request)
    {
        $emailTemplate = $this->find($request->input('template_id'));
        $emailData = [
            'from_name' => config('mail.from_name'),
            'from_email' => config('mail.from_email')
        ];
        $receivers = $request->input('receivers');
        foreach ($receivers as $receiver) {
            $emailBody = $emailTemplate->body;
            $emailSubject = $emailTemplate->subject;
            if (!isset($receiver['email']))
                continue;
            foreach ($receiver as $key => $value) {
                $emailBody = str_replace('{{' . $key . '}}', $value, $emailBody);
                $emailSubject = str_replace('{{' . $key . '}}', $value, $emailSubject);
            }
            $emailData['body'] = $emailBody;
            $emailData['subject'] = $emailSubject;
            $emailData['email'] = $receiver['email'];
            dispatch(new \App\Jobs\SendEmail($emailData));
        }
    }
}
