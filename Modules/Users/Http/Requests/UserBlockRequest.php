<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class UserBlockRequest extends YasnaRequest
{
    protected $model_name = "User";



    /**
     * @return bool
     */
    public function authorize()
    {
        if ($this->model->withDisabled()->is_not_a(($this->role_slug))) {
            return false;
        }

        if ($this->_submit == 'block') {
            return $this->model->canDelete();
        } else {
            return $this->model->canBin();
        }
    }
}
