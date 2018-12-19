<?php

namespace Modules\Users\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Modules\Users\Http\Requests\RoleActivenessRequest;
use Modules\Users\Http\Requests\RoleAdminsSaveRequest;
use Modules\Users\Http\Requests\RoleSaveRequest;
use Modules\Users\Http\Requests\RoleTitlesSaveRequest;
use Modules\Yasna\Services\YasnaController;
use Illuminate\Http\Request;

class RolesUpstreamController extends YasnaController
{
    protected $base_model  = "Role";
    protected $view_folder = "users::upstream.roles";



    /**
     * Called by service environment to form the index page of roles upstream tab.
     *
     * @param Request $search_request
     *
     * @return array
     */
    public static function index($search_request): array
    {
        return [
             "keyword"   => $search_request->keyword,
             "view_file" => "users::upstream.roles.browse.index",
             "models"    => static::indexModels($search_request->keyword),
        ];
    }



    /**
     * Gets a collection of models to be shown in index page.
     *
     * @param string $searched
     *
     * @return Collection
     */
    private static function indexModels($searched)
    {
        if ($searched) {
            return role()
                 ->withTrashed()
                 ->where('title', 'like', "%$searched%")
                 ->orWhere('plural_title', 'like', "%$searched%")
                 ->orWhere('slug', 'like', "%$searched%")
                 ->orderBy('created_at', 'desc')
                 ->paginate(user()->preference('max_rows_per_page'))
                 ;
        }

        return role()
             ->withTrashed()
             ->orderBy('created_at', 'desc')
             ->paginate(user()->preference('max_rows_per_page'))
             ;
    }



    /**
     * Prepares the model and returns the appropriate blade, by considering the twin parameters.
     *
     * @param string $action
     * @param string $hashid
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function action(string $action, $hashid = null)
    {
        if (!$this->isActionAllowed($action)) {
            return $this->abort(404);
        }

        $model = $this->actionModel($action, $hashid);
        if ($model->isNotSet() and $action != 'create') {
            return $this->abort(410);
        }

        if ($action == 'create') {
            $action = 'edit';
        }

        return $this->view("actions.$action", compact('model'));
    }



    /**
     * Finds the appropriate model for any action
     *
     * @param string $action
     * @param string $hashid
     *
     * @return Role
     */
    private function actionModel(string $action, string $hashid)
    {
        if ($action == 'admins') {
            return role(role()->adminRoles()[0], true)->spreadMeta();
        }
        if ($action == 'create') {
            return role();
        }

        return role($hashid, true)->spreadMeta();
    }



    /**
     * Determines if an action is valid.
     *
     * @param $action
     *
     * @return bool
     */
    private function isActionAllowed($action): bool
    {
        return in_array($action, [
             'edit',
             'create',
             'activeness',
             'row',
             'titles',
             'users',
             'admins',
        ]);
    }



    /**
     * Saves the submitted form data, both for create and edit actions
     *
     * @param RoleSaveRequest $request
     *
     * @return string
     */
    public function save(RoleSaveRequest $request): string
    {
        $saved = $request->model->batchSaveBoolean($request);
        role()->cacheRegenerate();

        return $this->jsonAjaxSaveFeedback($saved, [
             'success_callback' => "rowUpdate('tblRoles','$request->hashid')",
        ]);
    }



    /**
     * Activates / Deactivates a role
     *
     * @param RoleActivenessRequest $request
     *
     * @return string
     */
    public function saveActiveness(RoleActivenessRequest $request)
    {
        if ($request->_submit == 'delete') {
            $done = $request->model->delete();
        } else {
            $done = $request->model->restore();
        }

        return $this->jsonAjaxSaveFeedback($done, [
             'success_callback' => "rowUpdate('tblRoles','$request->hashid')",
        ]);
    }



    /**
     * Saves all admin roles at once
     *
     * @param RoleAdminsSaveRequest $request
     *
     * @return string
     */
    public function saveAllAdmins(RoleAdminsSaveRequest $request)
    {
        /**
         * @var Role $role
         */
        $roles = role()->where('is_admin', 1)->get();

        foreach ($roles as $role) {
            $role->batchSave($request);
        }

        return $this->jsonAjaxSaveFeedback(true);
    }



    /**
     * Saves Titles
     *
     * @param RoleTitlesSaveRequest $request
     *
     * @return string
     */
    public function saveTitles(RoleTitlesSaveRequest $request)
    {
        $saved = $request->model->batchSaveBoolean($request);

        return $this->jsonAjaxSaveFeedback($saved, [
             'success_callback' => "rowUpdate('tblRoles','$request->hashid')",
        ]);
    }
}
