<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class DepartmentSearchMemberRequest extends YasnaRequest
{
    protected $model_name = "Role";



    /**
     * return the name of the username field.
     *
     * @return string
     */
    public function usernameField()
    {
        return user()->usernameField();
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             $this->usernameField() => 'required',
        ];
    }



    /**
     * @inheritdoc
     */
    public function purifier()
    {
        return [
             $this->usernameField() => 'ed',
        ];
    }



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        $model = $this->model;

        return ($model->isSupportRole());
    }
}
