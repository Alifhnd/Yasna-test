<?php

namespace Modules\Post\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class TagsStoreRequest extends YasnaRequest
{
    protected $model_name = "Tag";
    //Feel free to define purifier(), rules(), authorize() and messages() methods, as appropriate.

    public function rules()
    {
        return [
             'title' => 'required | max : 10'

        ];
    }



    public function messages()
    {
        return [

             'title.required'=>trans_safe('post::message.TagsTitle_required')

        ];
    }
}
