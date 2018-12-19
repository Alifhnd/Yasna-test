<?php

namespace Modules\Yasna\Entities\Traits;

use Modules\Users\Events\UserRolesChanged;

trait AuthorizationTraitTouch
{
    /**
     * Touches user row, to update the roles catch and raise event
     *
     * @return bool
     */
    private function rolesUpdated()
    {
        $updated = $this->userRowCacheUpdate();
        if ($updated) {
            $this->raiseEventOnAnyChange();
        }

        return $updated;
    }



    /**
     * Updates the `cache_roles` field of the main User row, so that the `updated_at` can be used to check if the
     * session cache is expired.
     *
     * @return bool
     */
    private function userRowCacheUpdate()
    {
        $user   = clone $this;
        $roles  = $user->withDefaultChain()->withDisabled()->rolesQuery(true);
        $string = null;

        foreach ($roles as $role) {
            $extension = $role['slug'];
            if ($role['pivot']['deleted_at']) {
                $extension .= ".bin";
            } else {
                $extension .= '.' . strval($role['pivot']['status']);
            }

            $string .= " $extension ";
        }

        return $this->update([
             "cache_roles" => role()->defaceString($string) . strval(rand(10000, 99999)),
        ]);
    }



    /**
     * Raises an event on any role/permission/status change
     *
     * @return array|null
     */
    private function raiseEventOnAnyChange()
    {
        return event(new UserRolesChanged($this));
    }



    /**
     * adorns defaced string, stored in `cache_roles` field of users table
     *
     * @param string $original_value
     *
     * @return string
     */
    public function getCacheRolesAttribute($original_value)
    {
        return role()->adornString($original_value);
    }
}
