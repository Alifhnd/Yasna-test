<?php

namespace Modules\Post\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class PostStoreRequest extends YasnaRequest
{
    protected $model_name = "Post";
    //Feel free to define purifier(), rules(), authorize() and messages() methods, as appropriate.



    /**
     * @return array
     */
    public function rules()
    {
        return [
             'postTitle'=>'required',
             'postContent'=>'required',
             'tag'=>'required'
        ];
    }



    /**
     * @return array for rules
     */

    public function messages()
    {
        return [
             'postTitle.required'=>trans('post::message.postTitle_required'),
             'postContent.required'=>trans('post::message.postContent_required'),
             'postTags.required'=>trans('post::message.postTags_required'),

        ];
    }



    /**
     * @return bool
     */

    //public function authorize()
    //{
    //    return $this->model->can('edit');
    //}
}
