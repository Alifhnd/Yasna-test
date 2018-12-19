<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Modules\Yasna\Http\Requests\SimpleYasnaRequest;
use Modules\Yasna\Services\YasnaController;

class WeatherController extends YasnaController
{
    protected $view_folder = 'manage::';
    protected $base_model  = 'menu';



    /**
     * Show modal for change state.
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function chooseStateModal()
    {
        $options   = [];
        $provinces = model('State')->where('parent_id', '0')->get();
        foreach ($provinces as $province) {
            $children = $this->children($province->id);
            foreach ($children as $child) {
                array_push($options, [
                     'id'    => $child->id,
                     'title' => $province->title . " > " . $child->title,
                ]);
            }
        }
        return $this->view('dashboard.weather.states', compact('options'));
    }



    /**
     * update user preference state_id
     *
     * @param SimpleYasnaRequest $request
     *
     * @return string
     */
    public function updateState(SimpleYasnaRequest $request)
    {
        $state_id = $request->state_id;
        user()->setPreference('state_id', $state_id);
        $success_callback = "divReload('divWidget-manage-weather-body')";

        return $this->jsonAjaxSaveFeedback(true, compact('success_callback'));
    }



    /**
     * return children of parent state
     *
     * @param integer $parent_id
     *
     * @return Collection
     */
    public function children($parent_id)
    {
        return model('State')->where('parent_id', $parent_id)->get();
    }


}
