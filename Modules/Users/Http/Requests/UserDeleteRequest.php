<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class UserDeleteRequest extends YasnaRequest
{
    protected $model_name = "User";



    /**
     * @return bool
     */
    public function authorize()
    {
        if ($this->_submit == 'delete') {
            return $this->model->canDelete();
        } else {
            return $this->model->canBin();
        }
    }
}
