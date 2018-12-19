<?php

namespace Modules\Trans\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class EditTransRequest extends YasnaRequest
{
    protected $model_name = "";



    //Feel free to define purifier(), rules(), authorize() and messages() methods, as appropriate.
    public function rules()
    {
        return [
             'slug' => 'required',
        ];
    }
}
