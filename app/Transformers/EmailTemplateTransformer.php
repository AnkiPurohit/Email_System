<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\EmailTemplate;

/**
 * Class EmailTemplateTransformer.
 *
 * @package namespace App\Transformers;
 */
class EmailTemplateTransformer extends TransformerAbstract
{
    /**
     * Transform the EmailTemplate entity.
     *
     * @param \App\Entities\EmailTemplate $model
     *
     * @return array
     */
    public function transform(EmailTemplate $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
