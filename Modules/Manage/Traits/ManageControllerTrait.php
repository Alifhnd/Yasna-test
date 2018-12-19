<?php

namespace Modules\Manage\Traits;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

trait ManageControllerTrait
{

    /*
    |--------------------------------------------------------------------------
    | Response Methods
    |--------------------------------------------------------------------------
    |
    */


    /**
     * responses to the update-row request from the grid views and depends on the environment variables set in the main
     * controller constructor
     *
     * @param $model_id
     *
     */
    public function edit($model_hashid)
    {
        /*-----------------------------------------------
        | Model ...
        */
        $base_model   = $this->base_model;
        $with_trashed = boolval($base_model->hasColumn('deleted_at'));

        $model = $base_model::findByHashid($model_hashid, [
            'with_trashed' => $with_trashed,
        ]);

        if (!$model or !$model->exists) {
            return $this->abort(410, true);
        }

        $model->spreadMeta();

        /*-----------------------------------------------
        | View ...
        */

        return $this->safeView($this->view_folder . '.browse-row', compact('model'));
    }

    public function singleAction($model_hashid, $view_file, ... $option)
    {
        /*-----------------------------------------------
        | Mass Action Bypass ...
        */
        if ($model_hashid == 'mass') {
            return $this->massAction($view_file, ... $option);
        }

        /*-----------------------------------------------
        | Special Method Before Model Retreive ...
        */
        $special_method = camel_case($view_file . "_root_form");
        if (method_exists($this, $special_method)) {
            return $this->$special_method($model_hashid, ... $option);
        }

        /*-----------------------------------------------
        | Model ...
        */
        $base_model   = $this->base_model;
        $with_trashed = method_exists($base_model, "restore");
        if ($model_hashid == '0' or $model_hashid == hashid(0)) {
            $model = new $base_model();
        } else {
            $model = $base_model::findByHashid($model_hashid, [
                'with_trashed' => $with_trashed,
            ]);

            if (!$model or !$model->exists) {
                return $this->abort(410, true);
            }

            $model->spreadMeta();
        }

        /*-----------------------------------------------
        | Special Method after Model Retreive  ...
        */
        $special_method = camel_case($view_file . "_form");
        if (method_exists($this, $special_method)) {
            return $this->$special_method($model, ... $option);
        }

        /*-----------------------------------------------
        | View ...
        */

        return $this->safeView($this->view_folder . "." . $view_file, compact('model', 'option'));
    }

    public function massAction($view_file, ... $option)
    {
        /*-----------------------------------------------
        | Special Method ...
        */
        $special_method = camel_case($view_file . "_mass_form");
        if (method_exists($this, $special_method)) {
            return $this->$special_method();
        }

        /*-----------------------------------------------
        | Normal View ...
        */

        return $this->safeView($this->view_folder . "." . $view_file . '-mass', compact('option'));
    }

    protected function safeView($view_file, $arguments = false)
    {
        if (!View::exists($view_file)) {
            if (config('app.debug')) {
                return ss("view file [$view_file] not found!");
            } else {
                return $this->abort(404, true);
            }
        }

        return view($view_file, $arguments);
    }

    /*
    |--------------------------------------------------------------------------
    | Simple Return
    |--------------------------------------------------------------------------
    | Just for the ease of access
    */
    private function feedback($is_ok = false, $message = null)
    {
        if (!$is_ok) {
            if (!$message) {
                $message = trans('manage::forms.feed.error');
            }
            echo ' <div class="alert alert-danger">' . $message . '</div> ';
            die();
        } else {
            if (!$message) {
                $message = trans('manage::forms.feed.done');
            }
            echo ' <div class="alert alert-success">' . $message . '</div> ';
            die();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Shortcuts to Json Feeds
    |--------------------------------------------------------------------------
    |
    */

    private function jsonFeedback($message = null, $setting = [])
    {
        //Preferences...
        if (!$message) {
            $message = trans('validation.invalid');
        }
        if (is_array($message) and !sizeof($setting)) {
            $setting = $message;
        }

        $default = [
            'ok'           => 0,
            'message'      => $message,
            'redirect'     => '',
            'callback'     => '',
            'refresh'      => 0,
            'modalClose'   => 0,
            'updater'      => '',
            'redirectTime' => 1000,
            'feed_class'   => "no",
        ];

        foreach ($default as $item => $value) {
            if (!isset($setting[ $item ])) {
                $setting[ $item ] = $value;
            }
        }

        //Normalization...
        if ($setting['redirect']) {
            $setting['redirect'] = url($setting['redirect']);
        }

        //Action...
        return json_encode($setting);
    }

    private function jsonSaveFeedback($is_saved, $setting = [])
    {
        //Preferences...
        $default = [
            'success_message'      => trans('manage::forms.feed.done'),
            'success_redirect'     => '',
            'success_callback'     => '',
            'success_refresh'      => '0',
            'success_modalClose'   => '0',
            'success_updater'      => '',
            'success_form_reset'   => '',
            'success_feed_timeout' => 0,
            'redirectTime'         => 1000,

            'danger_message'    => trans('validation.invalid'),
            'danger_redirect'   => '',
            'danger_callback'   => '',
            'danger_refresh'    => '0',
            'danger_modalClose' => '0',
            'danger_updater'    => '',
        ];

        foreach ($default as $item => $value) {
            if (!isset($setting[ $item ])) {
                $setting[ $item ] = $value;
            }
        }

        //Action...
        if ($is_saved) {
            return $this->jsonFeedback(null, [
                'ok'           => '1',
                'message'      => $setting['success_message'],
                'redirect'     => $setting['success_redirect'],
                'callback'     => $setting['success_callback'],
                'refresh'      => $setting['success_refresh'],
                'modalClose'   => $setting['success_modalClose'],
                'updater'      => $setting['success_updater'],
                'form_reset'   => $setting['success_form_reset'],
                'feed_timeout' => $setting['success_feed_timeout'],
                'redirectTime' => $setting['redirectTime'],
            ]);
        } else {
            return $this->jsonFeedback([
                'ok'           => '0',
                'message'      => $setting['danger_message'],
                'redirect'     => $setting['danger_redirect'],
                'callback'     => $setting['danger_callback'],
                'refresh'      => $setting['danger_refresh'],
                'modalClose'   => $setting['danger_modalClose'],
                'updater'      => $setting['danger_updater'],
                'redirectTime' => $setting['redirectTime'],
            ]);
        }
    }

    private function jsonAjaxSaveFeedback($is_saved, $setting = [])
    {
        $setting = array_normalize($setting, [
            'success_message'      => trans('manage::forms.feed.done'),
            'success_redirect'     => '',
            'success_callback'     => '',
            'success_refresh'      => '0',
            'success_modalClose'   => '1',
            'success_updater'      => '',
            'success_form_reset'   => '',
            'success_feed_timeout' => 0,
            'redirectTime'         => 1000,

            'danger_message'    => trans('validation.invalid'),
            'danger_redirect'   => '',
            'danger_callback'   => '',
            'danger_refresh'    => '0',
            'danger_modalClose' => '0',
            'danger_updater'    => '',
        ]);

        //Action...
        return $this->jsonSaveFeedback($is_saved, $setting);
    }

    /**
     * @param       $errorCode
     * @param bool  $minimal if true minimal view will be loading
     * @param bool  $affectHeader if true header or response will be changed into $errorCode
     * @param mixed $data
     *
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     *
     */
    public function abort($errorCode, $minimal = false, $affectHeader = false, $data = null)
    {
        $headerStatus = $affectHeader ? $errorCode : 200;

        // Return response with custom data
        if (!is_null($data)) {
            if (is_array($data)) {
                return response()->json($data, $headerStatus);
            } else {
                return response($data, $errorCode);
            }
        }

        // Fetch $minimal from error code if needed
        if (str_contains($errorCode, 'm') or Request::ajax()) {
            $errorCode = str_after($errorCode, 'm');
            $minimal   = true;
        }

        // Return default errors in minimal or default format
        if ($minimal) {
            return response(view('yasna::errors.m' . $errorCode), $headerStatus);
        } else {
            return response(view('yasna::errors.' . $errorCode), $headerStatus);
        }
    }

    public function update($model_id, $adding = null)
    {
        //Tab exception...
        if ($model_id == 'tab') {
            $db         = $this->Model;
            $page       = $this->page;
            $page[1][0] = str_replace('-', '/', $adding);

            return view($this->view_folder . '.tabs', compact('db', 'page'));
        }

        //Preparations...
        $model = model($this->model_name, $model_id, 1);
        //$handle = $this->browse_handle;

        //Run...
        if (!$model) {
            return view('errors.m410');
        } else {
            $model->spreadMeta();

            return view($this->view_folder . '.browse-row', compact('model', 'handle'));
        }
    }
}
