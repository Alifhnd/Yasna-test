<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class UserProfileRequest extends YasnaRequest
{
    protected $model_name         = "user";
    protected $model_with_trashed = false;



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return userProfile($this->model)->isAvailable();
    }
}
