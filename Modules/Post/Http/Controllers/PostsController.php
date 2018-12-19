<?php

namespace Modules\Post\Http\Controllers;

use Modules\Post\Http\Requests\PostStoreRequest;
use Modules\Yasna\Services\YasnaController;

class PostsController extends YasnaController
{
    protected $base_model  = "Post";
    protected $view_folder = "post::posts";
    public $page;



    /**
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $model = model('Post')->all();

        $this->getPostInfo();
        $page = $this->page[0];
        $tabs[0] = [
             'caption' => 'test'
        ];


        return $this->view('list', compact('model' , 'page', 'tabs' ));
    }



    public function getPostInfo()
    {
        $this->page[0] = [
             $url = "post::posts/list",
        ];
        return $this->page[0];

        //$this->page[1] = [
        //     $this->request_tab,
        //     trans("users::criteria." . $this->role_model->statusRule($this->request_tab)),
        //     "users/browse/$this->request_role",
        //     "$url/$this->request_tab"];
    }


    /**
     * show the form in new resource
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function create()
    {
        $model = model('Post');
        return $this->view('create', compact('model', 'tags'));

    }



    /**
     * @param PostStoreRequest $request
     *
     * @return string
     */
    public function store(PostStoreRequest $request)
    {

        $save_model = $request->model->batchSave([
             "post_title"   => $request->postTitle,
             "post_content" => $request->postContent,
             "post_status"  => $request->postStatus,
        ]);

        return $this->jsonAjaxSaveFeedback($save_model->exists, [
             "success_message" => trans_safe('post::message.post_success_created'),
        ]);


        //$post = new Post();
        //$post = $post->storePost($request);
        //
        //return back()->with('status', trans('post::message.post_success_created'));

    }



    //public function edit(Request  $post_id)
    //{
    //
    //    $post     = Post::find($post_id);
    //    $statuses = Post::getPostStatus();
    //
    //    return view('edit', compact('post', 'statuses'));
    //}
    //
    //
    //
    //public function delete(Request $post_id)
    //{
    //    $post       = Post::find($post_id);
    //    $deletePost = $post->delete();
    //    if ($deletePost) {
    //        return back()->with('status', trans('post::message.post_success_deleted'));
    //    }
    //}


}
