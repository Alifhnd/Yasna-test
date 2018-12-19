<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class UserPermitRequest extends YasnaRequest
{
    protected $model_name = "User";



    /**
     * @return bool
     */
    public function authorize()
    {
        return
             $this->checkRoleOwnership() and
             $this->checkAdminPermissions() and
             $this->checkAdminPrivileges();
    }



    /**
     * @return bool
     */
    private function checkRoleOwnership()
    {
        return $this->model->withDisabled()->is_a($this->role_slug);
    }



    /**
     * @return bool
     */
    private function checkAdminPermissions()
    {
        return $this->model->as($this->role_slug)->canPermit();
    }



    /**
     * Admins can only set permissions for what they have.
     *
     * @return bool
     */
    private function checkAdminPrivileges()
    {
        if (not_in_array($this->role_slug, model("Role")->adminRoles())) {
            return true;
        }

        $permits = explode_not_empty(' ', $this->permissions);
        foreach ($permits as $permit) {
            if (user()->as_any()->cannot($permit) and $this->model->as_any()->can()) {
                return false;
            }
        }

        return true;
    }
}
