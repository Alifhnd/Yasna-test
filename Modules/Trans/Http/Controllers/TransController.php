<?php

namespace Modules\Trans\Http\Controllers;

use App\Models\Trans;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Modules\Trans\Http\Requests\EditTransRequest;
use Modules\Yasna\Services\YasnaController;
use  Illuminate\Http\Request;

/**
 * Class TransController
 *
 * @package Modules\Trans\Http\Controllers
 */
class TransController extends YasnaController
{
    protected $base_model  = 'Trans';
    protected $view_folder = 'trans::downstream';
    protected $row_view    = 'grid';



    /**
     * show trans in downstream tabs
     *
     * @param Request $request
     *
     * @return array
     */
    public static function downstreamTab(Request $request)
    {
        $view_data['view_file'] = "trans::downstream.browse";
        $view_data['models']    = model('trans')
             ->where('value', '<>', '')
             ->groupBy('slug')
        ;

        if (!dev()) {
            $view_data['models']->where('developer_only', 0);
        }

        if ($request->has('keyword')) {
            $key                 = $request->get('keyword');
            $view_data['models'] = $view_data['models']->where('value', 'like', "%$key%");
        }
        $limit                = 20;
        $view_data['models']  = $view_data['models']->paginate($limit)->appends($request->all());
        $view_data['offset']  = (($request->page ?? 1) - 1) * $limit;
        $view_data['request'] = $request;
        return $view_data;
    }



    /**
     * show edit modal of dynamic trans
     *
     * @param string $hashid
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditPage($hashid)
    {
        $view_data['hashid']  = $hashid;
        $view_data['locales'] = getSetting('site_locales');
        $view_data['model']   = model('trans', $hashid);
        return view('trans::downstream.edit_trans', $view_data);
    }



    /**
     * show edit modal of dynamic trans
     *
     * @param string $hashid
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDeletePage($hashid)
    {
        $view_data['hashid']  = $hashid;
        $view_data['locales'] = getSetting('site_locales');
        $view_data['model']   = model('trans', $hashid);
        return view('trans::downstream.delete_trans', $view_data);
    }



    /**
     * show add modal of dynamic trans
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAddPage()
    {
        $view_data['locales'] = getSetting('site_locales');

        return view('trans::downstream.add_trans', $view_data);
    }



    /**
     * add a item to dynamic trans
     *
     * @param EditTransRequest $request
     *
     * @return string
     * @throws \Exception
     */
    public function addTrans(EditTransRequest $request)
    {
        if (!dev()) {
            return;
        }
        if ($this->checkExist($request->get('slug'))) {
            return $this->jsonSaveFeedback(false, [
                 'danger_message' => trans('trans::downstream.exits'),
                 'danger_refresh' => '0',
            ]);
        }
        $values       = $request->get('values');
        $locales      = getSetting('site_locales');
        $dev_only     = $request->get('developer_only');
        $update_array = $this->makeArrayUpdate($values, $locales, $dev_only);
        $is_saved     = $this->save($request->get('slug'), $update_array);
        return $this->jsonSaveFeedback($is_saved, [
             'success_message' => trans('trans::downstream.edit_modal.saved'),
             'success_refresh' => '1',
             'danger_message'  => trans('trans::downstream.edit_modal.error'),
             'danger_refresh'  => '0',
        ]);
    }



    /**
     * edit dynamic trans items
     *
     * @param EditTransRequest $request
     *
     * @return string
     * @throws \Exception
     */
    public function editTrans(EditTransRequest $request)
    {
        $values      = $request->get('values');
        $locales     = getSetting('site_locales');
        $model       = model('trans', $request->get('hashid'));
        $slug        = $model->slug;
        $dev_only    = 0;
        $update_slug = null;
        if (dev()) {
            $dev_only = $request->get('developer_only');
            //check if slug has changed
            if ($slug != $request->get('slug')) {
                $update_slug = $request->get('slug');
            }
        }
        $update_array = $this->makeArrayUpdate($values, $locales, $dev_only);
        $is_saved     = $this->save($slug, $update_array, $update_slug);
        return $this->jsonAjaxSaveFeedback($is_saved, [
             'success_message'  => trans('trans::downstream.edit_modal.saved'),
             'success_callback' => "rowUpdate('translations','$model->hashid')",
             'danger_message'   => trans('trans::downstream.edit_modal.error'),
             'danger_refresh'   => '0',
        ]);
    }



    /**
     * delete a item of dynamic trans
     *
     * @param Request $request
     *
     * @return string|null
     * @throws \Exception
     */
    public function deleteTrans(Request $request)
    {
        if (!$request->has("hashid")) {
            return null;
        }
        $hashid  = $request->get('hashid');
        $slug    = model('trans', $hashid)->slug;
        $transes = model('trans')->where('slug', $slug)->get();
        //clear cache for this trans
        foreach ($transes as $trans) {
            \cache()->forget($slug . "." . $trans->locale);
        }

        $is_delete = model('trans')->where('slug', $slug)
                                   ->delete()
        ;

        return $this->jsonAjaxSaveFeedback($is_delete, [
             'success_message'  => trans('trans::downstream.edit_modal.saved'),
             'success_callback' => "rowUpdate('translations','$request->hashid')",
             'danger_message'   => trans('trans::downstream.delete_modal.error'),
             'danger_refresh'   => '0',
        ]);
    }



    /**
     * make array to insert db
     *
     * @param     array $values
     * @param     array $locales
     * @param int       $developer_only
     *
     * @return array
     */
    private function makeArrayUpdate($values, $locales, $developer_only = 0)
    {
        $updateArray = [];
        $i           = 0;
        foreach ($locales as $locale) {
            $updateArray[$i]['locale']         = $locale;
            $updateArray[$i]['value']          = $values[$locale];
            $updateArray[$i]['developer_only'] = $developer_only;
            $i++;
        }
        return $updateArray;
    }



    /**
     * check that this slug exists in dynamic trans
     *
     * @param string $slug
     *
     * @return bool
     */
    private function checkExist($slug)
    {
        return model('trans')->grabSlug($slug)->exists;
    }



    /**
     * save dynamic trans item
     *
     * @param  string $slug
     * @param  array  $trans_array
     * @param string  $update_slug
     *
     * @return bool
     * @throws \Exception
     */
    private function save($slug, $trans_array, $update_slug = null)
    {

        foreach ($trans_array as $item) {
            if (model('trans')->where('slug', $slug)->where('locale', $item['locale'])->first()) {
                $update_array['value']          = $item['value'];
                $update_array['developer_only'] = $item['developer_only'];

                if (!is_null($update_slug)) {
                    $update_array['slug'] = $update_slug;
                }

                $this->updateOrDelete($slug, $item, $update_array);
            } else {
                $this->addRecord($item, (is_null($update_slug)) ? $slug : $update_slug);
            }
        }
        return true;
    }



    /**
     * update or delete dynamic trans item
     *
     * @param string $slug
     * @param array  $item
     * @param array  $update_arr
     *
     * @throws \Exception
     */
    private function updateOrDelete($slug, $item, $update_arr)
    {
        if (empty($item['value'])) {
            model('trans')->where('slug', $slug)
                          ->where('locale', $item['locale'])
                          ->delete()
            ;
        } else {
            model('trans')->where('slug', $slug)
                          ->where('locale', $item['locale'])
                          ->first()
                          ->batchSave($update_arr)
            ;
        }
        \cache()->forget($slug . "." . $item['locale']);
    }



    /**
     * add record to the dynamic trans
     *
     * @param array  $item
     * @param string $slug
     *
     * @throws \Exception
     */
    private function addRecord($item, $slug)
    {
        if (!empty($item['value'])) {
            model('trans')->batchSave([
                 'value'          => $item['value'],
                 'locale'         => $item['locale'],
                 'developer_only' => $item['developer_only'],
                 'slug'           => $slug,
            ]);
            \cache()->forget($slug . "." . $item['locale']);
        }
    }
}
