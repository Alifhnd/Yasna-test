<?php

namespace Modules\Post\Http\Controllers;

use Modules\Post\Http\Requests\TagsStoreRequest;
use Modules\Yasna\Services\YasnaController;

class TagsController extends YasnaController
{
    protected $base_model  = "Tag"; //
    protected $view_folder = "post::tags";



    /**
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $model = model('Tag');
        return $this->view('create', compact('model'));
    }



    /**
     * create new tag
     *
     * @param TagsStoreRequest $request
     *
     * @return string
     */
    public function store(TagsStoreRequest $request)
    {
        $save_tag = $request->model->batchSave($request);

        return $this->jsonAjaxSaveFeedback($save_tag, [
             'success_message' => trans('post::message.success_tag'),
        ]);
    }
}
