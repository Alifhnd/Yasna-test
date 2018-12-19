<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Manage\Traits\ManageControllerTrait;

class DownstreamController extends Controller
{
    use ManageControllerTrait;



    /**
     * prepare downstream settings
     *
     * @param string  $request_tab
     * @param bool    $option
     * @param Request $search_request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index($request_tab = '_default_', $option = false, Request $search_request)
    {
        /*-----------------------------------------------
        | Tabs ...
        */
        $raw_tabs = module('manage')->service('downstream')->read();
        $tab_list = array_pluck($raw_tabs, 'link');
        $tabs     = [];
        foreach ($raw_tabs as $raw_tab) {
            $tabs[] = [
                 $raw_tab['link'],
                 $raw_tab['caption'],
            ];
        }

        /*-----------------------------------------------
        | Default Tab ...
        */
        if ($request_tab == '_default_') {
            $request_tab = $tab_list[0];
        }

        /*-----------------------------------------------
        | Current Tab ...
        */
        if (!in_array($request_tab, $tab_list) /*or !View::exists($view_file)*/) {
            return $this->abort(404);
        }
        $current_tab     = array_first(array_where($raw_tabs, function ($value, $key) use ($request_tab) {
            return $value['link'] == $request_tab;
        }));
        $request_caption = $current_tab['caption'];

        /*-----------------------------------------------
        | Special Controller ...
        */
        $controller_result = $current_tab['method']($search_request, $option);

        /*-----------------------------------------------
        | Page ...
        */
        $page[0] = ['downstream', trans('manage::settings.site')];
        $page[1] = [$request_tab, $request_caption];
        if (isset($controller_result['page'])) {
            foreach ($controller_result['page'] as $controller_page) {
                $page[] = $controller_page;
            }
        }

        /*-----------------------------------------------
        | View ...
        */

        return view($controller_result['view_file'], array_merge($controller_result, compact('page', 'tabs')));
    }
}
