<?php namespace Modules\Manage\Http\Controllers;

use Modules\Manage\Http\Requests\SettingActivenessRequest;
use Modules\Manage\Http\Requests\SettingSaveRequest;
use Modules\Manage\Http\Requests\SettingSetRequest;
use Modules\Yasna\Services\YasnaController;

class UpstreamSettingsController extends YasnaController
{
    protected $base_model = "Setting";



    /**
     * Called automatically via services
     *
     * @param $search_request
     *
     * @return mixed
     */
    public static function index($search_request)
    {
        /*-----------------------------------------------
        | View File ...
        */
        $result['view_file'] = "manage::upstream.settings";

        /*-----------------------------------------------
        | Search Request ...
        */
        $keyword = $search_request->keyword;

        /*-----------------------------------------------
        | Model ...
        */
        if ($keyword) {
            $result['models']  = setting()->where('title', 'like', "%$keyword%")
                                          ->orWhere('slug', 'like', "%$keyword%")
                                          ->withTrashed()
                                          ->orderBy('order')
                                          ->orderBy('title')
                                          ->paginate(user()->preference('max_rows_per_page'))
            ;
            $result['keyword'] = $keyword;
        } else {
            $result['models'] = setting()->orderBy('order')
                                         ->withTrashed()
                                         ->orderBy('title')
                                         ->paginate(user()->preference('max_rows_per_page'))
            ;
        }

        /*-----------------------------------------------
        | Return ...
        */

        return $result;
    }



    /**
     * @param SettingActivenessRequest $request
     *
     * @return string
     */
    public function saveActiveness(SettingActivenessRequest $request)
    {
        if ($request->_submit == 'delete') {
            $done = $request->model->delete();
        } else {
            $done = $request->model->restore();
        }

        return $this->jsonAjaxSaveFeedback($done, [
             'success_callback' => "rowUpdate('tblSettings','$request->hashid')",
        ]);
    }



    /**
     * @param SettingSetRequest $request
     *
     * @return string
     */
    public function set(SettingSetRequest $request)
    {
        return $this->jsonAjaxSaveFeedback($request->model->setFromPanel($request), [
             'success_callback' => "rowUpdate('tblSettings','$request->hashid')",
        ]);
    }



    /**
     * @param SettingSaveRequest $request
     *
     * @return string
     */
    public function save(SettingSaveRequest $request)
    {
        $done = $request->model->batchSave($request);

        return $this->jsonAjaxSaveFeedback($done, [
             'success_callback' => "rowUpdate('tblSettings','$request->hashid')",
        ]);
    }
}
