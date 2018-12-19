<?php

namespace Modules\Yasna\Entities\Traits;

trait RoleAdminsTrait
{
    /**
     * get an array of admin roles.
     *
     * @param string $additive
     *
     * @deprecated (97/5/10)
     * @return array
     */
    public static function adminRoles($additive = null)
    {
        $admin_roles = cache()->remember("admin_roles-$additive", 100, function () use ($additive) {
            $roles = role()->where('is_admin', true)->get();
            $array = [];
            foreach ($roles as $role) {
                $array[] = $role->slug . $additive;
            }

            return $array;
        });

        return $admin_roles;
    }



    /**
     * get an array of admin role slugs.
     *
     * @return array
     */
    public function adminSlugs()
    {
        return self::adminRoles();
    }



    /**
     * get the eloquent model of the first admin role
     *
     * @return \App\Models\Role
     */
    public function firstAdminRole()
    {
        return role($this->adminSlugs()[0]);
    }
}
