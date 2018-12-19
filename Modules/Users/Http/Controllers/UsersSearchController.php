<?php namespace Modules\Users\Http\Controllers;

use Illuminate\Http\Request;

class UsersSearchController extends UsersBrowseController
{
    protected $search_request;
    protected $request_tab     = 'search';
    protected $showing_results = false;
    protected $role_string     = null;



    /**
     * @param $request_role
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function panel($request_role)
    {
        $this->request_role = $request_role;

        if (!$this->checkPermission()) {
            return $this->abort(403);
        }
        if (!$this->getRoleModel()) {
            return $this->abort(404);
        }

        $this->setSearchUrl();
        $this->buildPageInfo();
        $this->buildViewArguments();

        return $this->view('search', $this->view_arguments);
    }



    /**
     * @param         $request_role
     * @param Request $request
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function search($request_role, Request $request)
    {
        $this->request_role    = $request_role;
        $this->search_request  = $request;
        $this->showing_results = true;

        if (!$this->checkPermission()) {
            return $this->abort(403);
        }
        if (!$this->getRoleModel()) {
            return $this->abort(404);
        }

        $this->buildPageInfo();
        $this->queryBuilder();
        $this->buildViewArguments();
        $this->handleServices();

        return $this->view('index', $this->view_arguments);
    }



    /**
     * Query Buillder
     */
    public function queryBuilder()
    {
        $this->generateRoleStringForSearch();

        $elector_switches = [
             'roleString' => $this->role_string,
             //'status'     => 'search',
             'search'     => $this->search_request->keyword,
        ];

        $this->models = model('User')
             ->elector($elector_switches)
             ->orderBy('created_at', 'desc')
             ->simplePaginate(20)
        ;
    }



    /**
     * Generates $role_string to be used in query builder
     */
    protected function generateRoleStringForSearch()
    {
        $this->role_string = $this->role_model->slug;

        if ($this->role_string=='all') {
            $this->role_string = false;
        }
    }



    /**
     * View Arguments
     */
    public function buildViewArguments()
    {
        parent::buildViewArguments();

        if ($this->showing_results) {
            $this->view_arguments['keyword'] = $this->search_request->keyword;
        }
    }



    /**
     * Page Info
     */
    public function buildPageInfo()
    {
        parent::buildPageInfo();

        if ($this->showing_results) {
            $this->page[1] = [
                 $this->request_tab,
                 trans('manage::forms.button.search_for') . SPACE . $this->search_request->keyword,
                 "users/browse/$this->request_role",
                 $this->page[0][0] . "/$this->request_tab",
            ];
        }
    }
}
