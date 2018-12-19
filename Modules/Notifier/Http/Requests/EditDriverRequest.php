<?php

namespace Modules\Notifier\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class EditDriverRequest extends YasnaRequest
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             'driver_title' => 'required',
             'driver_name'  => 'required',
             'fields_name'  => 'required',
        ];
    }



    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [
             'driver_title.required' => trans('notifier::general.miss-driver-title'),
             'driver_name.required'  => trans('notifier::general.miss-driver-name'),
             'fields_name.required'  => trans('notifier::general.miss-fields-name'),
        ];
    }


}
