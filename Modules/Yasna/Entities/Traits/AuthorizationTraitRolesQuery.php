<?php

namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * Trait PermitsTrait2Roles
 *
 * @property int $id
 * @property     $updated_at
 * @method Builder belongsToMany($table)
 * @method bool IsLoggedIn()
 * @method bool IsNotLoggedIn()
 * @package Modules\Yasna\Entities\Traits
 */
trait AuthorizationTraitRolesQuery
{


    /**
     * Laravel standard many to many relation method.
     *
     * @return Builder
     */
    public function roles()
    {
        return $this->belongsToMany(MODELS_NAMESPACE . 'Role')
                    ->withPivot('permissions', 'status', 'deleted_at', 'key')
                    ->withTimestamps()
             ;
    }



    /**
     * Gets a fresh list of roles, removing all illegally modified ones.
     *
     * @return \Illuminate\Support\Collection
     */
    public function fetchRoles()
    {
        $roles = $this->roles()->get();
        $array = [];

        foreach ($roles as $key => $role) {
            $role->adorn();
            $role_array = $role->toArray();

            if ($this->checkKey($role_array)) {
                $array[$key] = $role_array;
            }
        }

        return collect($array);
    }



    /**
     * Catches role in session, if the user in question is logged in
     *
     * @param Collection $collection
     */
    private function catchRolesIfLoggedIn(Collection $collection)
    {
        if ($this->isLoggedIn()) {
            session()->put('logged_user_roles', $collection);
            session()->put('logged_user_revealed_at', now()->toDateTimeString());
        }
    }



    /**
     * @return bool|Collection
     */
    private function getRolesFromCatch()
    {
        $revealed_at = session()->get('logged_user_revealed_at', false);
        $roles       = session()->get('logged_user_roles', false);

        if ($this->isNotLoggedIn() or !$roles or !$revealed_at or $revealed_at < $this->updated_at) {
            return false;
        }

        return $roles;
    }



    /**
     * Gets collection of all user roles from either database or if possible from the session.
     *
     * @param bool $force_fresh
     *
     * @return Collection
     */
    public function getRoles(bool $force_fresh = false)
    {
        $cached_roles = $this->getRolesFromCatch();

        if ($force_fresh or !$cached_roles) {
            $roles = $this->fetchRoles();
            $this->catchRolesIfLoggedIn($roles);
            return $roles;
        }

        return $cached_roles;
    }



    /**
     * Runs a query through the available collection, considering all the Chain property limitations.
     *
     * @param bool $force_fresh
     *
     * @return Collection
     */
    public function rolesQuery(bool $force_fresh = false)
    {
        $query = $this
             ->getRoles($force_fresh)
             ->where('pivot.status', '>=', $this->min_status)
             ->where('pivot.status', '<=', $this->max_status)
        ;

        if ($this->as_role) {
            $query = $query->whereIn('slug', $this->as_role);
        }

        if (!$this->with_disableds) {
            $query = $query->where('pivot.deleted_at', null);
        }

        return $query;
    }



    /**
     * Gets an array of role slugs, user has assigned to
     *
     * @param bool $force_fresh
     *
     * @return array
     */
    public function rolesArray(bool $force_fresh = false)
    {
        return $this->rolesQuery($force_fresh)->pluck('slug')->toArray();
    }
}
