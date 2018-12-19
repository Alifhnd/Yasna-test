<?php

namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Collection;

/**
 * Trait RoleSupportTrait, attached to Role
 * Responsible to organize everything related to `support` special roles.
 *
 * @property $slug
 */
trait RoleSupportTrait
{
    public static $support_role_prefix = 'support';



    /**
     * check if the current role is a supportive one.
     *
     * @return bool
     */
    public function isSupportRole(): bool
    {
        return str_contains($this->slug, self::$support_role_prefix . '-');
    }



    /**
     * check if the current role is a supportive one.
     *
     * @deprecated
     * @return bool
     */
    public function getIsSupportAttribute()
    {
        return $this->isSupportRole();
    }



    /**
     * get a collection of support roles.
     *
     * @return Collection
     */
    public static function supportRoles()
    {
        $support_roles = cache()->remember("support_roles", 100, function () {
            return role()->where('slug', 'like', self::$support_role_prefix . '-%')->orderBy('title')->get();
        });

        return $support_roles;
    }



    /**
     * checks if any support role has been defined.
     *
     * @return bool
     */
    public function supportRolesDefined(): bool
    {
        return boolval($this->supportRoles()->count());
    }



    /**
     * gets a support eloquent model by its slug, with or without prefix
     *
     * @param string $slug
     *
     * @return \App\Models\Role
     */
    public function findDepartment(string $slug)
    {
        $prefix = static::$support_role_prefix . "-" . $slug;

        if (str_contains($slug, $prefix)) {
            return role($slug);
        }

        return role($prefix . $slug);
    }
}
