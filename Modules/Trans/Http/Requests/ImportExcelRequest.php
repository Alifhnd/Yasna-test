<?php

namespace Modules\Trans\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class ImportExcelRequest extends YasnaRequest
{
    protected $model_name = "trans";



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return user()->isDeveloper();
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             'file' => 'required|excel',
        ];
    }



    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [
             "excel" => trans('trans::downstream.excel.not_valid'),
        ];
    }
}
