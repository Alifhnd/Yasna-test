<?php
namespace Modules\Users\Entities\Traits;

/**
 * Class UserCanTrait
 *
 * @package Modules\Users\Entities\Traits
 * @property $not_exists
 * @method bool isTrashed()
 */
trait UserCanTrait
{
    public $temporary_role_slug = 'all';



    /**
     * @param string $request_permit
     * @param bool   $allow_self
     *
     * @deprecated
     * @return bool
     */
    public function canDo($request_permit, $allow_self = false)
    {
        /*-----------------------------------------------
        | Developer Exception ...
        */
        if ($this->is_a('developer')) {
            return dev();
        }
        /*-----------------------------------------------
        | Self Exception ...
        */
        if (!$allow_self and $this->id == user()->id) {
            return false;
        }
        /*-----------------------------------------------
        | Other Users ...
        */
        foreach ($this->as('all')->rolesArray() as $role_slug) {
            if (user()->as('admin')->can("users-$role_slug.$request_permit")) {
                return true;
            }
        }
        /*-----------------------------------------------
        | If doesn't have a role ...
        */
        return user()->as('admin')->can("users-all.$request_permit");
    }



    /**
     * @param        $as_role
     * @param string $permit
     * @param bool   $allow_self
     *
     * @return bool|mixed
     */
    public function canBeAffected($as_role, $permit = '*', $allow_self = false)
    {
        /*-----------------------------------------------
        | Simple Decisions ...
        */
        if ($this->not_exists or $this->isTrashed()) {
            return false;
        }
        if (model('Role', $as_role)->not_exists) {
            return false;
        }


        /*-----------------------------------------------
        | Developer Exception ...
        */
        if ($this->is_a('developer')) {
            return dev();
        }

        /*-----------------------------------------------
        | Self Exception ...
        */
        if (!$allow_self and $this->id == user()->id) {
            return false;
        }

        /*-----------------------------------------------
        | Real Decision ...
        */
        return user()->as('admin')->can("users-$as_role.$permit");
    }



    /**
     * @param string $permit
     * @param bool   $allow_self
     *
     * @return bool
     */
    public function canBeAffectedAsAllRoles($permit = '*', $allow_self = false)
    {
        foreach ($this->as('all')->rolesArray() as $role_slug) {
            if ($this->canBeAffected($role_slug, $permit, $allow_self)) {
                return true;
            }
        }

        return user()->as('admin')->can("users-all.$permit");
    }



    /**
     * @param        $as_role
     * @param string $permit
     * @param bool   $allow_self
     *
     * @return bool
     */
    public function cannotBeAffected($as_role, $permit = '*', $allow_self = false)
    {
        return !$this->canBeAffected($as_role, $permit, $allow_self);
    }



    /**
     * @param string $permit
     * @param bool   $allow_self
     *
     * @return bool
     */
    public function cannotBeAffectedAsAllRoles($permit = '*', $allow_self = false)
    {
        return !$this->canBeAffectedAsAllRoles($permit, $allow_self);
    }



    /**
     * @return bool
     */
    public function canEdit()
    {
        return $this->canDo('edit');
    }



    /**
     * @return bool
     */
    public function canDelete()
    {
        return $this->canDo('delete');
    }



    /**
     * @return bool
     */
    public function canBin()
    {
        return $this->canDo('bin');
    }



    /**
     * @return bool
     */
    public function canCreate()
    {
        $role_slug = $this->getChain('as');

        if ($role_slug == 'admin') {
            foreach ($this->as('all')->rolesArray() as $role_slug) {
                if (user()->as('admin')->can("users-$role_slug.create")) {
                    return true;
                }
            }
        }

        if (is_array($role_slug)) {
            $permit_array = [];
            foreach ($role_slug as $role) {
                $permit_array[] = "users-$role.create";
            }
            return user()->as('admin')->can_any($permit_array);
        }

        return user()->as('admin')->can("users-$role_slug.create");
    }



    /**
     * Decides whether to use canCreate() or canEdit()
     *
     * @return bool
     */
    public function canCreateOrEdit()
    {
        if ($this->id) {
            return $this->canEdit();
        }

        return $this->canCreate();
    }



    /**
     * @deprecated
     * @return bool
     */
    public function canPermit()
    {
        $request_role = $this->getChain('as');

        if (is_array($request_role)) {
            $request_role = $request_role[0];
        }

        /*-----------------------------------------------
        | Simple Decisions ...
        */
        //if ($request_role and !model("Role", $request_role)->has_modules) {
        //    return false;
        //}

        if ($this->trashed()) {
            return false;
        }
        if ($this->id == user()->id) {
            return false;
        }
        if ($this->is_a('developer')) {
            return user()->is_a('developer');
        }
        //if($this->as($request_role)->status()<8) {
        //	return false ;
        //}

        /*-----------------------------------------------
        | In case of a specified role ...
        */
        if ($request_role) {
            return user()->as('admin')->can("users-$request_role.permit");
        }

        /*-----------------------------------------------
        | In case of generally called ...
        */
        if (!$request_role) {
            return user()->as_any()->can('users-all.permit');
        }

        /*-----------------------------------------------
        | Just in case :) ...
        */

        return false;
    }



    /**
     * Determines if the online user can assign this roles to this user
     *
     * @param      $role_slug
     * @param      $new_status
     *
     * @return bool
     */
    public function canBeAssigned($role_slug, $new_status)
    {
        if ($this->is_not_a($role_slug)) {
            return $this->canBeAffected($role_slug, 'create');
        }

        if ($this->withDisabled()->is_not_a($role_slug)) {
            return $this->canBeAffected($role_slug, 'bin');
        }

        if ($new_status == 'ban' or $new_status == 'detach') {
            return $this->canBeAffected($role_slug, 'delete');
        }

        return $this->canBeAffected($role_slug, 'edit');
    }



    /**
     * Reversed situation of $this->canBeAssigned() method
     *
     * @param      $role_slug
     * @param null $new_status
     *
     * @return bool
     */
    public function cannotBeAssigned($role_slug, $new_status)
    {
        return !$this->canBeAssigned($role_slug, $new_status);
    }
}
