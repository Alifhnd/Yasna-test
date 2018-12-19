<?php namespace Modules\Users\Http\Controllers;

use Modules\Users\Events\UserRolesChanged;
use Modules\Users\Http\Requests\PasswordChangeRequest;
use Modules\Users\Http\Requests\UserBlockRequest;
use Modules\Users\Http\Requests\UserDeleteRequest;
use Modules\Users\Http\Requests\UserPermitRequest;
use Modules\Users\Http\Requests\UserSaveRequest;
use Modules\Yasna\Services\YasnaController;
use Modules\Users\Http\Requests\LoginAsRequest;
use Nwidart\Modules\Facades\Module;

class UsersActionController extends YasnaController
{
    protected $base_model  = "User";
    protected $view_folder = "users::actions";



    /**
     * @param PasswordChangeRequest $request
     *
     * @return string
     */
    public function savePassword(PasswordChangeRequest $request)
    {
        $is_saved = $request->model->batchSaveBoolean($request);

        return $this->jsonAjaxSaveFeedback($is_saved);
    }



    /**
     * @param LoginAsRequest $request
     *
     * @return string
     */
    public function loginAs(LoginAsRequest $request)
    {
        session()->invalidate();
        session()->put('last_user', user()->id);
        login($request->model->id);
        return $this->jsonAjaxSaveFeedback(true, [
             'success_redirect' => url('manage'),
        ]);
    }



    public function createForm($role_slug = null)
    {
        $model = model('User');
        return $this->view('edit', compact('model', 'role_slug'));
    }



    /**
     * @param UserSaveRequest $request
     *
     * @return string
     */
    public function save(UserSaveRequest $request)
    {
        $saved_model = $request->model->batchSave($request);

        $this->attachRoleToNewUser($saved_model, $request);

        return $this->jsonAjaxSaveFeedback($saved_model->exists, [
             'success_callback' => "rowUpdate('tblUsers','$request->model_hashid')",
        ]);
    }



    /**
     * @param $saved_model
     * @param $request
     */
    private function attachRoleToNewUser($saved_model, $request)
    {
        if ($request->model->id) {
            return;
        }

        $saved_model->attachRole($request->_role_slug);
    }



    /**
     * @param UserBlockRequest $request
     *
     * @return string
     */
    public function blockOrUnblock(UserBlockRequest $request)
    {
        if ($request->_submit == 'block') {
            $ok = $request->model->disableRole($request->role_slug);
        } else {
            $ok = $request->model->enableRole($request->role_slug);
        }

        return $this->jsonAjaxSaveFeedback($ok, [
             'success_callback' => "rowUpdate('tblUsers','$request->model_hashid')",
        ]);
    }



    public function deleteOrUndelete(UserDeleteRequest $request)
    {
        if ($request->_submit == 'delete') {
            $ok = $request->model->delete();
        } else {
            $ok = $request->model->restore();
        }

        return $this->jsonAjaxSaveFeedback($ok, [
             'success_callback' => "rowUpdate('tblUsers','$request->model_hashid')",
        ]);
    }



    /**
     * @param $user_id
     * @param $role_slug
     * @param $new_status
     */
    public function saveRole($user_id, $role_slug, $new_status)
    {
        /*-----------------------------------------------
        | Model and Permission ...
        */
        $user = user($user_id);
        chalk()->add($new_status);


        if (!$user->exists) {
            return $this->jsonFeedback(trans('validation.http.Error410'));
        }
        if ($user->cannotBeAssigned($role_slug, $new_status)) {
            return $this->jsonFeedback(trans('validation.http.Error503'));
        }

        /*-----------------------------------------------
        | Save ...
        */
        $ok = $this->saveRoleStatus($user, $role_slug, $new_status);

        /*-----------------------------------------------
        | Feedback...
        */

        return $this->jsonAjaxSaveFeedback(true); //<~~ Row is automatically refreshed upon receiving of the done feedback!
    }



    /**
     * @param $user
     * @param $role_slug
     * @param $new_status
     *
     * @return boolean
     */
    private function saveRoleStatus($user, $role_slug, $new_status)
    {
        if ($new_status == 'detach') {
            $ok = $user->detachRole($role_slug);
        } elseif ($new_status == 'ban') {
            $ok = $user->disableRole($role_slug);
        } else {
            if ($user->withDisabled()->hasnotRole($role_slug)) {
                $ok = $user->attachRole($role_slug, $new_status);
            } elseif ($user->as($role_slug)->disabled()) {
                $ok = $user->enableRole($role_slug);
            }

            $ok = $user->as($role_slug)->setStatus($new_status);
        }

        //if ($ok) {
        //    event(new UserRolesChanged($user));
        //}

        return $ok;
    }



    /**
     * @param $model
     * @param $role_hashid
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function refreshRoleRowForm($model, $role_hashid)
    {
        $role = model('Role', $role_hashid);

        return $this->view("roles-one-combo", compact('model', 'role'));
    }



    /**
     * @param $model
     * @param $role_slug
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function permitsForm($model, $role_slug)
    {
        $request_role = model("Role", $role_slug);
        if (!$request_role->exists) {
            return $this->abort(410);
        }

        /*-----------------------------------------------
        | Models ...
        */
        $modules = $request_role->modules_array;
        $roles   = model("Role")->all();


        /*-----------------------------------------------
        | View ...
        */
        return $this->view("permits", compact("model", "request_role", "roles", "modules"));
    }



    /**
     * @param UserPermitRequest $request
     *
     * @return string
     */
    public function savePermits(UserPermitRequest $request)
    {
        $this->saveRoleStatus($request->model, $request->role_slug, $request->status);
        $this->saveSupportRoles($request);
        $this->setPermissions($request);

        return $this->jsonAjaxSaveFeedback(true, [
             'success_callback' => "rowUpdate('tblUsers','$request->model_hashid')",
        ]);
    }



    /**
     * @param $request
     */
    private function saveSupportRoles($request)
    {
        foreach (model("Role")->supportRoles() as $support_role) {
            $model_value = $request->model->is_a($support_role->slug);
            $input_value = $request->toArray()[$support_role->slug];

            if ($model_value != $input_value) {
                if ($input_value) {
                    $request->model->attachRole($support_role->slug);
                } else {
                    $request->model->detachRole($support_role->slug);
                }
            }
        }
    }



    /**
     * @param $request
     */
    private function setPermissions($request)
    {
        $request->model->as($request->role_slug)->setPermission($request->permissions);
    }

}
