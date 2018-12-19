<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Manage\Traits\ManageControllerTrait;

class StatueController extends Controller
{
    use ManageControllerTrait;



    /**
     * @param       $file_name
     * @param array $attachments
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Support\Facades\View|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    protected function view($file_name, $attachments = [])
    {
        return $this->safeView("manage::statue.$file_name", $attachments);
    }



    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Support\Facades\View|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        /*-----------------------------------------------
        | Page ...
        */
        $page[0] = ["statue", trans("manage::statue.title")];


        /*-----------------------------------------------
        | Modules ...
        */
        $models = module()->collection(user()->isDeveloper());

        /*-----------------------------------------------
        | View ...
        */

        return $this->view('index', compact('page', 'models'));
    }



    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function init()
    {
        session()->put('yasna_init_first', 1);
        return redirect(url("manage/statue"));
    }



    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function opCacheReset()
    {
        if (dev() and function_exists('opcache_reset')) {
            opcache_reset();
        }
        return redirect(url("manage/statue"));
    }



    /**
     * @param $module_slug
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Support\Facades\View|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function activeness($module_slug)
    {
        /*-----------------------------------------------
        | Permission ...
        */
        if (!user()->isDeveloper()) {
            return $this->abort(403, 1);
        }

        /*-----------------------------------------------
        | Module Selection ...
        */
        $module = module($module_slug)->collect(); //<~~ It's safe to use without double-check. A PHP error will be returned, in case of malfunction.

        /*-----------------------------------------------
        | View ...
        */
        return $this->view('activeness', compact("module"));
    }



    /**
     * @param Request $request
     *
     * @return string
     */
    public function saveActiveness(Request $request)
    {
        /*-----------------------------------------------
        | Module Activeness ...
        */
        $action = $request->_submit;
        $ok     = module($request->hashid)->$action();

        /*-----------------------------------------------
        | Artisan (triggered in the plane.blade, on the next page reload!) ...
        */
        session()->put('yasna_init_first', 2);

        /*-----------------------------------------------
        | Feedback ...
        */
        return $this->jsonAjaxSaveFeedback(true, [
             'success_refresh' => true,
        ]);
    }
}
