<?php

namespace Modules\Manage\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class ManageAddWidgetRequest extends YasnaRequest
{
    protected $model_name = "" ;
    //Feel free to define purifier(), rules(), authorize() and messages() methods, as appropriate.


    public function rules()
    {
        return [
            'widget' => "required" ,
        ];
    }
}
