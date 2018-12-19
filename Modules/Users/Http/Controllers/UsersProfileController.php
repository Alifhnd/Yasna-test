<?php

namespace Modules\Users\Http\Controllers;

use Modules\Users\Http\Requests\UserProfileRequest;
use Modules\Yasna\Services\YasnaController;
use Nwidart\Modules\Facades\Module;

class UsersProfileController extends YasnaController
{
    protected $base_model  = "User";
    protected $view_folder = "users::profile";



    /**
     * displays user profile modal
     *
     * @param UserProfileRequest $request
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(UserProfileRequest $request)
    {
        $model = $request->model;

        return $this->view('main', compact('model'));
    }



    /**
     * displays  demo of user profile modal
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function demo()
    {
        $model   = user();
        $is_demo = true;

        userProfile()->addBlade(
             $this->module()->getBladePath('profile.demo.blade1')
        );
        userProfile()->addBlade(
             $this->module()->getBladePath('profile.demo.blade2')
        );
        userProfile()->addBlade(
             $this->module()->getBladePath('profile.demo.blade3')
        );

        return $this->view('main', compact('model', 'is_demo'));
    }
}
