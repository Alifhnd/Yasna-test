<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class DepartmentAddMemberRequest extends YasnaRequest
{
    protected $model_name = "role";



    /**
     * @inheritdoc
     */
    public function purifier()
    {
        return [
             'user' => 'dehash',
        ];
    }
}
