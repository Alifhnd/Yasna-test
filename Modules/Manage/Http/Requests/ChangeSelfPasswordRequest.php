<?php

namespace Modules\Manage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeSelfPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_password' => "required",
            'new_password'     => 'required|min:8|max:60',
            'password2'        => "required|same:new_password",
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
