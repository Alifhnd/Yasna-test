<?php

namespace Modules\Manage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateCitySaveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required',
            'province_id' => 'required|numeric|exists:states,id,parent_id,0',
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
