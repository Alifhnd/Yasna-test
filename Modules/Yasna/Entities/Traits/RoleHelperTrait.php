<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait RoleHelperTrait, attached to Role
 */
trait RoleHelperTrait
{
    /**
     * get the role icon, suitable to be shown in the menus
     *
     * @return string
     */
    public function getMenuIconAttribute()
    {
        $icon = $this->getMeta('icon');

        if (!$icon) {
            $icon = "user";
        }

        return $icon;
    }



    /**
     * gets an array of all roles, plus any custom provided $additive
     *
     * @param null $additive
     *
     * @return array
     */
    public function allRoles(string $additive = null)
    {
        $all_roles = cache()->remember("all_roles-$additive", 100, function () use ($additive) {
            $roles = role()->all()->pluck('slug')->toArray();
            foreach ($roles as $key => $role) {
                $roles[$key] .= $additive;
            }

            return $roles;
        });

        return $all_roles;
    }
}
