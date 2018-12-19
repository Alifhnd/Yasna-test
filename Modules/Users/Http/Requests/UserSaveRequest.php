<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Modules\Yasna\Services\YasnaRequest;

class UserSaveRequest extends YasnaRequest
{
    protected $model_name = "User";



    /**
     * @return boolean
     */
    public function authorize()
    {
        if ($this->data['id']) {
            return $this->model->canEdit();
        }

        return $this->model->as($this->data['_role_slug'])->canCreate();
    }



    /**
     * @return array
     */
    public function dynamicRules()
    {
        $array = [];
        foreach (user()->renderFormItems() as $item) {
            if ($rules = $item['validation_rules']) {
                $array[$item['field_name']] = $rules;
            }
        }
        return $array;
    }



    /**
     * @return array
     */
    public function consistentRules()
    {
        $username_field = config("auth.providers.users.field_name");
        $id             = $this->model->id;

        return [
             $username_field => "$username_field|required|unique:users,$username_field,$id,id",
        ];
    }



    /**
     * @return array
     */
    public function purifier()
    {
        $array = [];
        foreach (user()->renderFormItems() as $item) {
            if ($rules = $item['purification_rules']) {
                $array[$item['field_name']] = $rules;
            }
        }
        return $array;
    }



    /**
     * Password Hash
     */
    public function _corrections()
    {
        if (!$this->model->id) {
            $this->data['password']              = Hash::make($this->data['password']);
            $this->data['password_force_change'] = 1;
        }
    }
}
