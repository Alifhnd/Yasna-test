<?php

namespace Modules\Manage\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\Manage\Http\Requests\SettingSetRequest;
use Modules\Yasna\Services\YasnaController;

class SettingsDownstreamController extends YasnaController
{
    protected $base_model  = "Setting";
    protected $view_folder = "manage::downstream";



    /**
     * form the index page of the downstream settings (called by service environment)
     *
     * @param Request $search_request
     *
     * @return array
     */
    public static function index($search_request)
    {
        return [
             "view_file" => "manage::downstream.settings",
             "models"    => self::prepareModels(),
        ];
    }



    /**
     * prepare a list of models available to be search through in front-end
     *
     * @return Collection
     */
    public static function prepareModels()
    {
        $builder = model("setting")->select("id", "slug", "title");

        if (!dev()) {
            $builder = $builder->where("category", "!=", "upstream");
        }

        return $builder->get();
    }



    /**
     * prepare the model and return the appropriate blade, by considering the twin parameters.
     *
     * @param  string $action
     * @param bool    $hashid
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function action($action, $hashid = false)
    {
        if (!$this->isActionAllowed($action)) {
            return $this->abort(404);
        }
        if (user()->as('admin')->cannot('settings.settings')) {
            return $this->abort(403);
        }


        $model    = model("setting", $hashid);
        $settings = model("setting")->where('category', $model->category)->orderBy('order')->orderBy('title')->get();

        if (!$model or !$model->id) {
            return $this->abort(410);
        }
        if ($model->category == 'upstream' and !dev()) {
            return $this->abort(503);
        }

        return $this->view("settings-$action", compact("model", "settings"));
    }



    /**
     * Determine if an action is valid.
     *
     * @param string $action
     *
     * @return bool
     */
    private function isActionAllowed($action)
    {
        return in_array($action, [
             'set-group',
             'set-single',
        ]);
    }



    /**
     * set the settings
     *
     * @param SettingSetRequest $request
     *
     * @return string
     */
    public function save(SettingSetRequest $request)
    {
        $counter = 0;
        foreach ($request->toArray() as $key => $value) {
            $item = explode("--in--", $key);
            $slug = $item[0];
            if (isset($item[1])) {
                $lang = $item[1];
            } else {
                $lang = null;
            }

            $setting = setting($slug);

            if (!$setting->exists) {
                continue;
            }
            if ($setting->isUpstream() and !dev()) {
                continue;
            }

            $counter += $setting->in($lang)->setValue($value);
        }

        return $this->jsonAjaxSaveFeedback($counter);
    }
}
