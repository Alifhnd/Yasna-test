<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class RoleActivenessRequest extends YasnaRequest
{
    protected $model_name = "Role";



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return !boolval($this->model->slug == 'manager');
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             "_submit" => "in:delete,restore",
        ];
    }
}
