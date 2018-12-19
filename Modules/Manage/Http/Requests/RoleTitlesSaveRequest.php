<?php

namespace Modules\Manage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleTitlesSaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $input = $this->all();
        $id = $input['id'] ;
        return [
            'title' => 'required|unique:roles,title,'.$id,
            'plural_title' => 'required',
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
