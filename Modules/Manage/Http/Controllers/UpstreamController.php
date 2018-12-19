<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Manage\Http\Requests\DomainSaveRequest;
use Modules\Manage\Http\Requests\StateCitySaveRequest;
use Modules\Manage\Http\Requests\StateSaveRequest;
use Modules\Manage\Traits\ManageControllerTrait;
use App\Models\Domain;
use App\Models\Setting;
use App\Models\State;

class UpstreamController extends Controller
{
    use ManageControllerTrait;



    public function index($request_tab = '_default_', $option = false, Request $search_request)
    {
        /*-----------------------------------------------
        | Tabs ...
        */
        $raw_tabs = module('manage')->service('upstream_tabs')->read(); // ManageServiceProvider::upstreamTabsServe();
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
        $page[0] = ['upstream', trans('manage::settings.upstream')];
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



    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    */


    public function settingAction($action, $hashid = false)
    {
        /*-----------------------------------------------
        | Action Check ...
        */
        if (!in_array($action, ['edit', 'set', 'create', 'row', 'activeness', 'seeder'])) {
            return $this->abort(404, true);
        }

        /*-----------------------------------------------
        | Model ...
        */
        if ($action == 'create') {
            $model = new Setting();
        } else {
            $model = Setting::findByHashid($hashid, [
                 'with_trashed' => true,
            ]);
            if (!$model or !$model->id) {
                return $this->abort(410, true);
            }
        }

        /*-----------------------------------------------
        | View ...
        */
        if ($action == 'create') {
            $view_file = "manage::upstream.settings-edit";
        } else {
            $view_file = "manage::upstream.settings-$action";
        }

        return view($view_file, compact('model'));
    }



    /*
    |--------------------------------------------------------------------------
    | States
    |--------------------------------------------------------------------------
    |
    */


    public static function stateIndex($search_request, $option)
    {
        /*-----------------------------------------------
        | Search Request ...
        */
        $keyword = $search_request->keyword;

        /*-----------------------------------------------
        | Model & View...
        */
        if ($keyword) {
            $result['models']    = State::withTrashed()
                                        ->where('title', 'like', "%$keyword%")
                                        ->orderBy('title')
                                        ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['keyword']   = $keyword;
            $result['view_file'] = "manage::upstream.states-cities";
            $result['page'][]    = [
                 'cities',
                 trans("manage::forms.button.search_for_something", [
                      "something" => $keyword,
                 ]),
            ];
        } elseif ($option) {
            $result['state']     = State::findByHashid($option, [
                 'with_trashed' => true,
            ]);
            $result['models']    = $result['state']->cities()
                                                   ->orderBy('title')
                                                   ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['view_file'] = "manage::upstream.states-cities";
            $result['page'][]    = [
                 'cities',
                 trans("yasna::states.cities_of_x", [
                      "x" => $result['state']->title,
                 ]),
            ];
        } else {
            $result['models']    = State::getProvinces()
                                        ->withTrashed()
                                        ->orderBy('title')
                                        ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['view_file'] = "manage::upstream.states";
        }

        /*-----------------------------------------------
        | Return ...
        */

        return $result;
    }



    public function stateAction($action, $hashid = false)
    {
        /*-----------------------------------------------
        | Action Check ...
        */
        if (!in_array($action, ['edit', 'create', 'row', 'activeness', 'cities-row', 'cities-edit', 'cities-create'])) {
            return $this->abort(404, true);
        }

        /*-----------------------------------------------
        | Model ...
        */
        if (in_array($action, ['create'])) {
            $model = new State();
        } else {
            $model = State::findByHashid($hashid, true, [
                 'with_trashed' => true,
            ]);
            if (!$model or !$model->id) {
                return $this->abort(410, true);
            }
        }

        /*-----------------------------------------------
        | City Creation Exception ...
        */

        if ($action == 'cities-create') {
            $parent_id        = $model->id;
            $model            = new State();
            $model->parent_id = $parent_id;
            $action           = 'cities-edit';
        }


        /*-----------------------------------------------
        | View ...
        */
        if ($action == 'create') {
            $view_file = "manage::upstream.states-edit";
        } else {
            $view_file = "manage::upstream.states-$action";
        }


        return view($view_file, compact('model'));
    }



    public function stateActiveness(Request $request)
    {
        switch ($request->toArray()['_submit']) {
            case 'delete':
                $model = State::find($request->id);
                if (!$model) {
                    return $this->jsonFeedback(trans('forms.general.sorry'));
                }
                $ok = State::where('id', $request->id)->delete();
                break;

            case 'restore':
                $ok = State::withTrashed()->where('id', $request->id)->restore();
                break;

            default:
                $ok = false;
        }


        return $this->jsonAjaxSaveFeedback($ok, [
             'success_callback' => "rowUpdate('tblStates','$request->id')",
        ]);
    }



    public function stateSave(StateSaveRequest $request)
    {
        model('State')->forgetCaches();
        return $this->jsonAjaxSaveFeedback(State::store($request), [
             'success_callback' => "rowUpdate('tblStates','$request->id')",
        ]);
    }



    public function stateCitySave(StateCitySaveRequest $request)
    {
        $data = $request->toArray();

        $data['parent_id'] = $data['province_id'];
        unset($data['province_id']);

        model('State')->forgetCaches();
        return $this->jsonAjaxSaveFeedback(State::store($data), [
             'success_callback' => "rowUpdate('tblStates','$request->id')",
        ]);
    }



    /*
    |--------------------------------------------------------------------------
    | Domains
    |--------------------------------------------------------------------------
    |
    */
    public static function domainIndex($search_request, $option)
    {
        /*-----------------------------------------------
        | View File ...
        */
        $result['view_file'] = "manage::upstream.domains";

        /*-----------------------------------------------
        | Search Request ...
        */
        $keyword = $search_request->keyword;

        /*-----------------------------------------------
        | Model ...
        */
        if ($keyword) {
            $result['models']  = Domain::withTrashed()
                                       ->where('title', 'like', "%$keyword%")
                                       ->orWhere('alias', 'like', "%$keyword%")
                                       ->orWhere('slug', 'like', "%$keyword%")
                                       ->orderBy('title')
                                       ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['keyword'] = $keyword;
        } elseif ($option) {
            $result['domain']    = Domain::findByHashid($option, [
                 'with_trashed' => true,
            ]);
            $result['models']    = $result['domain']->states()
                                                    ->orderBy('title')
                                                    ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['view_file'] = "manage::upstream.states-cities";
            $result['page'][]    = [
                 'cities',
                 trans("yasna::states.cities_of_x", [
                      "x" => $result['domain']->title,
                 ]),
            ];
        } else {
            $result['models'] = Domain::withTrashed()
                                      ->orderBy('created_at', 'desc')
                                      ->paginate(user()->preference('max_rows_per_page'))
            ;
        }

        /*-----------------------------------------------
        | Return ...
        */

        return $result;
    }



    public function domainAction($action, $hashid = false)
    {
        /*-----------------------------------------------
        | Action Check ...
        */
        if (!in_array($action, ['edit', 'create', 'row', 'activeness'])) {
            return $this->abort(404, true);
        }

        /*-----------------------------------------------
        | Model ...
        */
        if (in_array($action, ['create'])) {
            $model = new Domain();
        } else {
            $model = Domain::findByHashid($hashid, true, [
                 'with_trashed' => true,
            ]);
            if (!$model or !$model->id) {
                return $this->abort(410, true);
            }
        }

        /*-----------------------------------------------
        | View ...
        */
        if ($action == 'create') {
            $view_file = "manage::upstream.domains-edit";
        } else {
            $view_file = "manage::upstream.domains-$action";
        }


        return view($view_file, compact('model'));
    }



    public function domainSave(DomainSaveRequest $request)
    {
        $model = $request->model;
        $saved = $model->batchSaveBoolean($request);

        return $this->jsonAjaxSaveFeedback($saved, [
             'success_callback' => "rowUpdate('tblDomains','$model->hashid')",
        ]);
    }



    public function domainActiveness(Request $request)
    {
        switch ($request->toArray()['_submit']) {
            case 'delete':
                $model = Domain::find($request->id);
                if (!$model or $model->id == 1) {
                    return $this->jsonFeedback(trans('forms.general.sorry'));
                }
                $ok = Domain::where('id', $request->id)->delete();
                break;

            case 'restore':
                $ok = Domain::withTrashed()->where('id', $request->id)->restore();
                break;

            default:
                $ok = false;
        }


        return $this->jsonAjaxSaveFeedback($ok, [
             'success_callback' => "rowUpdate('tblDomains','$request->id')",
        ]);
    }
}
