<?php

namespace Modules\Manage\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Yasna\Providers\ValidationServiceProvider;

class ChangePersonalInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->get('_submit') == 'delete') {
            return [];
        }
        return [
             'name_first'    => "required",
             'name_last'     => "required",
             'tel_emergency' => "phone",
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



    /**
     * @inheritdoc
     *
     * @param null $keys
     *
     * @return array
     */
    public function all($keys = null)
    {
        $value    = parent::all();
        $purified = ValidationServiceProvider::purifier($value, [
             'tel_emergency' => "ed",
        ]);
        return $purified;
    }


}
