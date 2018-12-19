<?php namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Yasna\Services\YasnaController;

class UsersBrowseController extends YasnaController
{
    protected $base_model  = "User";
    protected $view_folder = "users::browse";
    protected $ajax_called = false;
    protected $request_role;
    protected $request_tab;
    protected $role_model;
    protected $row_refresh_url;
    protected $search_url;
    protected $page;
    protected $model;
    protected $models;
    protected $view_arguments;



    /**
     * @param      $model_hashid
     * @param null $request_role
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function update($model_hashid, $request_role = null)
    {
        $this->request_role = $request_role;
        $this->ajax_called  = true;

        $this->model = $this->findModel($model_hashid);
        if (!$this->model->exists) {
            return $this->abort('m410');
        }

        $this->getRoleModel();
        $this->setRowRefreshUrl();
        $this->buildViewArguments();
        $this->handleServices();

        return $this->view('row', $this->view_arguments);
    }



    /**
     * @param        $request_role
     * @param string $request_tab
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index($request_role, $request_tab = 'all')
    {
        $this->request_role = $request_role;
        $this->request_tab  = $request_tab;

        if (!$this->checkPermission()) {
            return $this->abort(403);
        }
        if (!$this->getRoleModel()) {
            return $this->abort(404);
        }

        $this->buildPageInfo();
        $this->queryBuilder();
        $this->setRowRefreshUrl();
        $this->setSearchUrl();
        $this->buildViewArguments();
        $this->handleServices();

        return $this->view('index', $this->view_arguments);
    }



    /**
     * @return boolean
     */
    public function checkPermission()
    {
        return model('Role')->checkManagePermission($this->request_role, $this->request_tab);
    }



    /**
     * @return bool
     */
    public function getRoleModel()
    {
        $special_method = "getRoleModelFor" . studly_case($this->request_role);
        if ($this->hasMethod($special_method)) {
            return $this->$special_method();
        }

        $this->role_model = model('role', $this->request_role);
        if (!$this->role_model->exists) {
            return false;
        }

        return true;
    }



    /**
     * @return bool
     */
    protected function getRoleModelForAll()
    {
        $this->role_model               = model('Role');
        $this->role_model->slug         = 'all';
        $this->role_model->plural_title = trans("users::forms.all_users");

        return true;
    }



    /**
     * @return bool
     */
    protected function getRoleModelForAdmin()
    {
        $this->role_model               = model('Role');
        $this->role_model->slug         = 'admin';
        $this->role_model->plural_title = trans("users::forms.all_admins");

        return true;
    }



    /**
     * Builds page info, to be used in manage top-bar, and stores the result in $this->page.
     */
    public function buildPageInfo()
    {
        $this->page[0] = [
             $url = "users/browse/$this->request_role",
             $this->role_model->plural_title,
             $url,
        ];

        $this->page[1] = [
             $this->request_tab,
             trans("users::criteria." . $this->role_model->statusRule($this->request_tab)),
             "users/browse/$this->request_role",
             "$url/$this->request_tab",
        ];
    }



    /**
     * Sets Row Refresh Url
     */
    public function setRowRefreshUrl()
    {
        $this->row_refresh_url = "manage/users/update/-hashid-/$this->request_role";
    }



    /**
     * Sets Search Url
     */
    public function setSearchUrl()
    {
        $this->search_url = url("manage/users/browse/$this->request_role/search-for");
    }



    /**
     * Runs the query builder and stores the result in $this->models
     */
    public function queryBuilder()
    {
        $elector_switches = [
             'roleString' => "$this->request_role.$this->request_tab",
             'status'     => $this->request_tab,
        ];

        $this->models = model("User")
             ->elector($elector_switches)
             ->orderBy('created_at', 'desc')
             ->simplePaginate(20)
        ;
    }



    /**
     * Builds view arguments and stores in $this->view_arguments
     */
    public function buildViewArguments()
    {
        $this->view_arguments = [
             "page"            => $this->page,
             "model"           => $this->model,
             "models"          => $this->models,
             "db"              => $this->base_model,
             "role"            => $this->role_model,
             "request_role"    => $this->request_role,
             "ajax"            => $this->ajax_called,
             "row_refresh_url" => $this->row_refresh_url,
             "search_url"      => $this->search_url,
             "controller"      => $this,
        ];
    }



    /**
     * Handles the on-demand services,related to users browse
     */
    public function handleServices()
    {
        service("users:mass_action_handlers")->handle($this->view_arguments);
        service("users:browse_headings_handlers")->handle($this->view_arguments);
        service("users:browse_button_handlers")->handle($this->view_arguments);
    }



    /**
     * Reads service-based row actions, depending on the model, and request_role, to render an indexed array of
     * actions, to be used on the "actions" tiny menu of each browse record.
     *
     * @param $model
     *
     * @return array
     */
    public function renderRowActions($model)
    {
        module('users')
             ->service('row_action_handlers')
             ->handle([
                  "model"        => $model,
                  "request_role" => $this->request_role,
             ])
        ;


        return module('users')
             ->service('row_actions')
             ->indexed('icon', 'caption', 'link', 'condition')
             ;
    }
}
