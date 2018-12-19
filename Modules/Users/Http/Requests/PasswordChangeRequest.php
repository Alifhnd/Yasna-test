<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Modules\Yasna\Services\YasnaRequest;

class PasswordChangeRequest extends YasnaRequest
{
    protected $model_name = "User" ;



    /**
     * @return array
     */
    public function rules()
    {
        return [
             'password' => 'required|min:8|max:60',
        ];
    }



    /**
     * @return boolean
     */
    public function authorize()
    {
        return $this->model->canEdit();
    }



    /**
     * Hashing the password
     */
    public function corrections()
    {
        $this->data['password'] = Hash::make($this->data['password']);
        $this->data['password_force_change'] = 1;
    }
}
