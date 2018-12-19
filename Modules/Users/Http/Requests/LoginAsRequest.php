<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class LoginAsRequest extends YasnaRequest
{
    protected $model_name = "User" ;

    public function authorize()
    {
        return dev();
    }
}
