<?php

namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;

trait AuthorizationTraitDomains
{
    /**
     * Gets a builder of all the domains, a user has access to
     *
     * @param string $required_permits
     * @param int    $min_status
     *
     * @return Builder
     */
    public function domainsQuery($required_permits = '', int $min_status = 8)
    {
        /*-----------------------------------------------
        | Bypass if user has manager role ...
        */
        if ($this->is('manager')) {
            return domain()->where('id', '!=', '0');
        }

        /*-----------------------------------------------
        | Normal Process ...
        */
        $roles         = $this->min($min_status)->rolesArray();
        $domains_array = [];
        $user          = clone $this;

        foreach ($roles as $role) {
            if ($required_permits) {
                if ($user->as($role)->cannot($required_permits)) {
                    continue;
                }
            }
            if (str_contains($role, role()->domainRolePrefix('-'))) {
                $domains_array[] = $role;
                $domains_array[] = str_replace(role()->domainRolePrefix('-'), null, $role);
            }
        }

        $domains = domain()->whereIn('slug', $domains_array);

        return $domains;
    }



    /**
     * Gets an array of all the domains, the user has access to.
     *
     * @param string $required_permits
     * @param int    $min_status
     *
     * @return array
     */
    public function domainsArray($required_permits = '', int $min_status = 8)
    {
        return $this
             ->domainsQuery($required_permits, $min_status)
             ->get()
             ->pluck('slug')
             ->toArray()
             ;
    }



    /**
     * Counts all the domains, the user has access to.
     *
     * @param string $required_permits
     * @param int    $min_status
     *
     * @return int
     */
    public function domainsCount($required_permits = '', int $min_status = 8)
    {
        return $this->domainsQuery($required_permits, $min_status)->count();
    }
}
