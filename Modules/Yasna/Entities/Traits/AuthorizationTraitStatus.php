<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitStatus
{
    /**
     * Replaces the status of role(s) passed by chain methods
     *
     * @param int $new_status
     *
     * @return bool
     */
    public function setStatus(int $new_status)
    {
        if (!$this->as_role) {
            return false;
        }

        $roles = $this->withDisabled()->rolesQuery();

        foreach ($roles as $role) {
            $this->roles()->updateExistingPivot($role['id'], [
                 "status" => $new_status,
                 "key"    => $this->makeKey([
                      "id"         => $role['id'],
                      "permits"    => $role['pivot']['permissions'],
                      "status"     => $new_status,
                      "deleted_at" => $role['pivot']['deleted_at'],
                 ]),
            ])
            ;
        }

        $this->rolesUpdated();
        return true;
    }



    /**
     * Gets the status of the first role passed by chain methods
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->withDisabled()->rolesQuery()->first()['pivot']['status'];
    }



    /**
     * Pretty shortcut to $this->getStatus()
     *
     * @return int
     */
    public function status()
    {
        return $this->getStatus();
    }
}
