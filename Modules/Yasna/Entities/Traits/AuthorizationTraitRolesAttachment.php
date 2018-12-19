<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitRolesAttachment
{


    /**
     * Attaches a single role to the user. existing role will be overridden.
     *
     * @param string $role_slug : id is accepted as well.
     * @param int    $status
     * @param string $permissions
     *
     * @return bool
     */
    public function attachRole($role_slug, $status = 1, $permissions = '')
    {
        $role = role($role_slug);
        if ($role->isNotSet()) {
            return false;
        }

        $attachment_array = [
             "permissions" => $role->defaceString($permissions),
             "status"      => $status,
             "deleted_at"  => null,
             "key"         => $this->makeKey([
                  "id"      => $role->id,
                  "permits" => $permissions,
                  "status"  => $status,
             ]),
        ];

        $this->roles()->detach($role->id);
        $this->roles()->attach($role->id, $attachment_array);
        $this->rolesUpdated();

        return true;
    }



    /**
     * Attaches a number of roles by their slug or id
     *
     * @param array ...$role_slugs
     *
     * @return int
     */
    public function attachRoles(... $role_slugs)
    {
        $done = 0;
        foreach ($role_slugs as $role_slug) {
            $done += $this->attachRole($role_slug);
        }

        return $done;
    }



    /**
     * Detaches a single role by its slug or id
     *
     * @param $role_slug
     *
     * @return bool
     */
    public function detachRole($role_slug)
    {
        $role = role($role_slug);
        if ($role->isNotSet()) {
            return false;
        }

        $this->roles()->detach($role->id);
        $this->rolesUpdated();

        return true;
    }



    /**
     * Detaches a number of roles by id or slug
     *
     * @param array ...$role_slugs
     *
     * @return int
     */
    public function detachRoles(...$role_slugs)
    {
        $done = 0;
        foreach ($role_slugs as $role_slug) {
            $done += $this->detachRole($role_slug);
        }

        return $done;
    }



    /**
     * Detaches all the roles attached to the user
     *
     * @return bool
     */
    public function detachAll()
    {
        $this->roles()->detach();
        $this->rolesUpdated();

        return true;
    }



    /**
     * Enables a single role of a user, using its `deleted_at` property.
     *
     * @param $role_slug
     *
     * @return bool
     */
    public function enableRole($role_slug)
    {
        $role = $this->as($role_slug)->firstRole();

        if (!$role or !$role['id'] or !$role['pivot']['deleted_at']) {
            return false;
        }

        $this->roles()->updateExistingPivot($role['id'], [
             "deleted_at" => null,
             "key"        => $this->makeKey([
                  "id"      => $role['id'],
                  "permits" => $role['pivot']['permissions'],
                  "status"  => $role['pivot']['status'],
             ]),
        ])
        ;

        $this->rolesUpdated();
        return true;
    }



    /**
     * Enables a number of user's existing but disabled roles
     *
     * @param array ...$role_slugs
     *
     * @return int
     */
    public function enableRoles(... $role_slugs)
    {
        $done = 0;
        foreach ($role_slugs as $role_slug) {
            $done += $this->enableRole($role_slug);
        }

        return $done;
    }



    /**
     * Disables a single role of a user, using its `deleted_at` property.
     *
     * @param $role_slug
     *
     * @return bool
     */
    public function disableRole($role_slug)
    {
        $now  = now()->toDateTimeString();
        $role = $this->as($role_slug)->firstRole(false);

        if (!$role or !$role['id']) {
            return false;
        }

        $this->roles()->updateExistingPivot($role['id'], [
             "deleted_at" => $now,
             "key"        => $this->makeKey([
                  "id"         => $role['id'],
                  "permits"    => $role['pivot']['permissions'],
                  "status"     => $role['pivot']['status'],
                  "deleted_at" => $now,
             ]),
        ])
        ;

        $this->rolesUpdated();
        return true;
    }



    /**
     * Disables a number of user's existing roles
     *
     * @param array ...$role_slugs
     *
     * @return int
     */
    public function disableRoles(... $role_slugs)
    {
        $done = 0;
        foreach ($role_slugs as $role_slug) {
            $done += $this->disableRole($role_slug);
        }

        return $done;
    }
}
