<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Database\QueryException;
use Modules\Users\Http\Requests\DepartmentAddMemberRequest;
use Modules\Users\Http\Requests\DepartmentRemoveMemberRequest;
use Modules\Users\Http\Requests\DepartmentSaveRequest;
use Modules\Users\Http\Requests\DepartmentSearchMemberRequest;
use Modules\Users\Providers\DepartmentsServiceProvider;
use Modules\Yasna\Services\YasnaController;

class DepartmentsController extends YasnaController
{
    protected $base_model  = "role";
    protected $view_folder = "users::downstream.departments";



    /**
     * root form of the create action.
     *
     * @param string $model_id
     * @param mixed  ...$options
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Support\Facades\View|\Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function createRootForm($model_id, ...$options)
    {
        return $this->singleAction($model_id, 'edit', ...$options);
    }



    /**
     * save a department
     *
     * @param DepartmentSaveRequest $request
     *
     * @return string
     */
    public function save(DepartmentSaveRequest $request)
    {
        $saved = $request->model->batchSave($request);
        role()->cacheRegenerate();

        return $this->jsonAjaxSaveFeedback($saved, [
             'success_callback' => "rowUpdate('auto','$request->hashid')",
        ]);
    }



    /**
     * delete or restore a department.
     *
     * @param string $model_id
     * @param array  ...$options
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteRootForm($model_id, ...$options)
    {
        $task         = $options[0];
        $with_trashed = ($task == 'undelete');
        if (!$this->model($model_id, $with_trashed)->isSupportRole()) {
            return $this->abort(403);
        }

        return $this->module()
                    ->RolesUpstreamController()
                    ->action('activeness', $model_id)
             ;
    }



    /**
     * search for users with their username.
     *
     * @param DepartmentSearchMemberRequest $request
     *
     * @return string
     */
    public function searchMember(DepartmentSearchMemberRequest $request)
    {
        $role            = $request->model;
        $current_members = $role->users->pluck('id')->toArray();
        $username_field  = $request->usernameField();
        $user            = user()
             ->firstOrNew([
                  $username_field => $request->$username_field,
             ]);

        if ($user->exists) {
            return $this->jsonFeedback([
                 'message'    => $this->view('members-search-result', [
                      'user'           => $user,
                      'role'           => $request->model,
                      'username_field' => $username_field,
                      'is_member'      => in_array($user->id, $current_members),
                 ])->render(),
                 'modalClose' => 0,
                 'feed_class' => " ",
            ]);
        } else {
            return $this->jsonFeedback([
                 'message' => trans_safe('users::department.user-not-found'),
            ]);
        }
    }



    /**
     * add the specified user to the specified department.
     *
     * @param DepartmentAddMemberRequest $request
     *
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function addMember(DepartmentAddMemberRequest $request)
    {
        $role = $request->model;
        $user = user($request->user);

        if ($role->not_exists or $user->not_exists) {
            return $this->abort(410, true, true);
        }

        $attached = $user->attachRole($role->slug);
        if ($attached) {
            $modal_url = str_after(DepartmentsServiceProvider::membersLink($role), 'modal:');
            return [
                 'callback' => <<<JS
             masterModal("$modal_url");
JS
                 ,
            ];
        } else {
            $message = trans_safe('users::department.member-not-added');
            return [
                 'callback' => <<<JS
             $.notify("$message", {status: 'danger', pos: 'bottom-left'});
            $('.modal-body').removeClass('loading');
JS
                 ,
            ];
        }

    }



    /**
     * remove the specified user from the specified department
     *
     * @param DepartmentRemoveMemberRequest $request
     *
     * @return array|\Symfony\Component\HttpFoundation\Response
     */
    public function removeMember(DepartmentRemoveMemberRequest $request)
    {
        $role = $request->model;
        $user = user($request->user);

        if ($role->not_exists or $user->not_exists) {
            return $this->abort(410, true, true);
        }

        $attached = $user->detachRole($role->slug);
        if ($attached) {
            $modal_url = str_after(DepartmentsServiceProvider::membersLink($role), 'modal:');
            return [
                 'callback' => <<<JS
             masterModal("$modal_url");
JS
                 ,
            ];
        } else {
            $message = trans_safe('users::department.member-not-removed');
            return [
                 'callback' => <<<JS
             $.notify("$message", {status: 'danger', pos: 'bottom-left'});
            $('.modal-body').removeClass('loading');
JS
                 ,
            ];
        }

    }
}
