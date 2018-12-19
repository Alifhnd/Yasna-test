<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitPermissions
{
    /**
     * Replaces the permissions of a single role with the given ones.
     * Role must be passed via the chain method as(). multiple roles are not supported.
     *
     * @param string $permissions
     *
     * @return bool
     */
    public function setPermission($permissions)
    {
        $role = $this->firstRole();

        if (!$this->as_role or !$role or !$role['id']) {
            return false;
        }

        $permissions = trim($permissions);

        $this->roles()->updateExistingPivot($role['id'], [
             "permissions" => role()->defaceString($permissions),
             "key"         => $this->makeKey([
                  'id'         => $role['id'],
                  "permits"    => $permissions,
                  "status"     => $role['pivot']['status'],
                  "deleted_at" => $role['pivot']['deleted_at'],
             ]),
        ])
        ;

        $this->rolesUpdated();
        return true;
    }



    /**
     * mirror to $this->setPermission()
     *
     * @param string $permissions
     *
     * @return bool
     */
    public function setPermissions($permissions)
    {
        return $this->setPermission($permissions);
    }



    /**
     * mirror to $this->setPermission()
     *
     * @param string $permissions
     *
     * @return bool
     */
    public function setPermit($permissions)
    {
        return $this->setPermission($permissions);
    }



    /**
     * mirror to $this->setPermission()
     *
     * @param string $permissions
     *
     * @return bool
     */
    public function setPermits($permissions)
    {
        return $this->setPermission($permissions);
    }



    /**
     * Gets the permissions of a single role (passed by chain), including disabled roles
     *
     * @return string
     */
    public function getPermissions()
    {
        return $this->firstRole()['pivot']['permissions'];
    }



    /**
     * mirror to $this->getPermissions()
     *
     * @return string
     */
    public function getPermits()
    {
        return $this->getPermissions();
    }



    /**
     * Adds permissions to the current permissions of the user
     * Role must be passed via the chain method as(). multiple roles are not supported.
     *
     * @param string $new_permits
     *
     * @return bool
     */
    public function addPermission($new_permits)
    {
        $current_array = explode_not_empty(SPACE, $this->getPermissions());
        $new_array     = explode_not_empty(SPACE, $new_permits);
        $new_permits   = null;

        foreach ($new_array as $new_item) {
            if (not_in_array($new_item, $current_array)) {
                $new_permits .= " $new_item ";
            }
        }

        return $this->setPermission($this->getPermissions() . $new_permits);
    }



    /**
     * A mirror to $this->addPermission
     *
     * @param string $new_permits
     *
     * @return bool
     */
    public function addPermissions($new_permits)
    {
        return $this->addPermission($new_permits);
    }



    /**
     * mirror to $this->addPermission()
     *
     * @param string $new_permits
     *
     * @return bool
     */
    public function addPermit($new_permits)
    {
        return $this->addPermission($new_permits);
    }



    /**
     * mirror to $this->addPermission()
     *
     * @param string $new_permits
     *
     * @return bool
     */
    public function addPermits($new_permits)
    {
        return $this->addPermission($new_permits);
    }



    /**
     * Removes permissions from the current permissions of the user
     * Role must be passed via the chain method as(). multiple roles are not supported.
     *
     * @param string $new_permits
     *
     * @return bool
     */
    public function removePermission($removing_permits)
    {
        $permits        = $this->getPermissions();
        $removing_array = explode_not_empty(SPACE, $removing_permits);

        foreach ($removing_array as $removing_item) {
            $permits = str_replace($removing_item, SPACE, $permits);
        }

        return $this->setPermission($permits);
    }



    /**
     * mirror to $this->removePermission()
     *
     * @param string $removing_permits
     *
     * @return bool
     */
    public function removePermit($removing_permits)
    {
        return $this->removePermission($removing_permits);
    }



    /**
     * mirror to $this->removePermission()
     *
     * @param string $removing_permits
     *
     * @return bool
     */
    public function removePermits($removing_permits)
    {
        return $this->removePermission($removing_permits);
    }



    /**
     * mirror to $this->removePermission()
     *
     * @param string $removing_permits
     *
     * @return bool
     */
    public function removePermissions($removing_permits)
    {
        return $this->removePermission($removing_permits);
    }
}
