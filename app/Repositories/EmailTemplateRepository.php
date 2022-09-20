<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface EmailTemplateRepository.
 *
 * @package namespace App\Repositories;
 */
interface EmailTemplateRepository extends RepositoryInterface
{
    public function sendBulkEmails($request);
}
