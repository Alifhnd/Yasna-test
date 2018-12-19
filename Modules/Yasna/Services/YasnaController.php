<?php namespace Modules\Yasna\Services;

use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

abstract class YasnaController extends Controller
{
    protected $view_folder = null;
    protected $row_view    = 'row';
    protected $base_model  = null;



    /*
    |--------------------------------------------------------------------------
    | Response Methods
    |--------------------------------------------------------------------------
    |
    */

    public function __construct()
    {
    }



    /**
     * responses to the update-row request from the grid views and depends on the environment variables set in the main
     * controller constructor
     *
     * @param $model_id
     */
    public function update($model_hashid, $spare = null)
    {
        /*-----------------------------------------------
        | Model ...
        */
        $model = $this->findModel($model_hashid);
        if (!$model or !$model->exists) {
            return $this->abort(410, true);
        }

        /*-----------------------------------------------
        | View ...
        */
        return $this->safeView($this->view_folder . '.' . $this->row_view, compact('model'));
    }



    /**
     * @param $model_hashid
     *
     * @return mixed
     */
    protected function findModel($model_hashid)
    {
        if (is_string($this->base_model)) {
            $this->base_model = model($this->base_model);
        }

        $with_trashed = boolval($this->base_model->hasColumn('deleted_at'));

        $model = $this->base_model->findByHashid($model_hashid, [
             'with_trashed' => $with_trashed,
        ]);

        return $model->spreadMeta();
    }



    /**
     * @param       $model_hashid
     * @param       $view_file
     * @param array ...$option
     *
     * @return ResponseFactory|Factory|View|\Illuminate\View\View|Response
     */
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
        $model = model($this->base_model);

        if ($model_hashid != '0' and $model_hashid != hashid(0)) {
            $model = $model->findByHashid($model_hashid, [
                 'with_trashed' => true,
            ]);

            if (!$model or !$model->exists) {
                return $this->abort(410);
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



    /**
     * @param       $view_file
     * @param array ...$option
     *
     * @return ResponseFactory|Factory|View|\Illuminate\View\View|Response
     */
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



    /**
     * safely load the view file with the given argument
     *
     * @param string $view_file
     * @param bool   $arguments
     *
     * @return View|Response
     */
    protected function safeView($view_file = null, $arguments = false)
    {
        if ($this->view_folder and !str_contains($view_file, $this->view_folder)) {
            if (!$view_file) {
                $view_file = $this->view_folder;
            } else {
                $view_file = "$this->view_folder.$view_file";
            }
        }
        if (!View::exists($view_file)) {
            if (config('app.debug')) {
                return ss("view file [$view_file] not found!");
            } else {
                return $this->abort(404, true);
            }
        }

        return view($view_file, $arguments);
    }



    /**
     * load the view file with the given arguments
     *
     * @param string $view_file
     * @param array  $arguments
     *
     * @return View|Response
     */
    protected function view($view_file = null, $arguments = [])
    {
        return $this->safeView($view_file, $arguments);
    }



    /*
    |--------------------------------------------------------------------------
    | Simple Return
    |--------------------------------------------------------------------------
    | Just for the ease of access
    */

    /**
     * @param bool $is_ok
     * @param null $message
     */
    protected function feedback($is_ok = false, $message = null)
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

    /**
     * @param null  $message
     * @param array $setting
     *
     * @return string
     */
    protected function jsonFeedback($message = null, $setting = [])
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
            if (!isset($setting[$item])) {
                $setting[$item] = $value;
            }
        }

        //Normalization...
        if ($setting['redirect']) {
            $setting['redirect'] = url($setting['redirect']);
        }

        //Action...
        return json_encode($setting);
    }



    /**
     * @param       $is_saved
     * @param array $setting
     *
     * @return string
     */
    protected function jsonSaveFeedback($is_saved, $setting = [])
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
            if (!isset($setting[$item])) {
                $setting[$item] = $value;
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



    /**
     * @param       $is_saved
     * @param array $setting
     *
     * @return string
     */
    protected function jsonAjaxSaveFeedback($is_saved, $setting = [])
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
     * @param $message
     *
     * @return View
     */
    public function customError($message)
    {
        $minimal = false;
        if (Request::ajax()) {
            $minimal = true;
        }

        if ($minimal) {
            return view('yasna::errors.m424', compact('message'));
        } else {
            return view('yasna::errors.424', compact('message'));
        }
    }



    /**
     * @param       $error_code
     * @param bool  $is_minimal   if true minimal view will be loading
     * @param bool  $affectHeader if true header or response will be changed into $errorCode
     * @param mixed $data
     *
     * @return Response
     */
    public function abort($error_code, $is_minimal = false, $affectHeader = false, $data = null)
    {
        $headerStatus = $affectHeader ? $error_code : 200;

        // Return response with custom data
        if (!is_null($data)) {
            if (is_array($data)) {
                return response()->json($data, $headerStatus);
            } else {
                return response($data, $error_code);
            }
        }

        // Fetch $minimal from error code if needed
        if (str_contains($error_code, 'm') or Request::ajax()) {
            $error_code = str_after($error_code, 'm');
            $is_minimal = true;
        }

        // Return default errors in minimal or default format
        if ($is_minimal) {
            return response(view('yasna::errors.m' . $error_code), $headerStatus);
        } else {
            return response(view('yasna::errors.' . $error_code), $headerStatus);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Module
    |--------------------------------------------------------------------------
    |
    */
    /**
     * @return string
     */
    protected function className()
    {
        $name  = get_class($this);
        $array = explode("\\", $name);
        return array_last($array);
    }



    /**
     * @return string
     */
    protected function moduleName()
    {
        $name  = get_class($this);
        $array = explode("\\", $name);

        if (array_first($array) == 'Modules') {
            return $array[1];
        }

        return null;
    }



    /**
     * @return ModuleHelper
     */
    protected function module()
    {
        return module($this->moduleName());
    }



    /**
     * @return string
     */
    public function moduleAlias()
    {
        return $this->module()->getAlias();
    }



    /**
     * @param int  $id
     * @param bool $with_trashed
     *
     * @return YasnaModel|mixed
     */
    protected function model($id = 0, $with_trashed = false)
    {
        return model($this->base_model, $id, $with_trashed);
    }



    /**
     * @param $method_name
     *
     * @return bool
     */
    protected function hasMethod($method_name)
    {
        return method_exists($this, $method_name);
    }



    /**
     * @param $method_name
     *
     * @return bool
     */
    protected function hasNotMethod($method_name)
    {
        return !$this->hasMethod($method_name);
    }



    /**
     * @return string
     */
    public function now()
    {
        return Carbon::now()->toDateTimeString();
    }
}
