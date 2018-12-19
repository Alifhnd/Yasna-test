<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Collection;

trait RoleDomainsTrait
{

    /**
     * @return Collection
     */
    public function domainRoles()
    {
        $domain_roles = cache()->remember('domain_roles', 100, function () {
            return model('role')->where('slug', 'like', $this->domain_role_prefix . '-%')->orderBy('title')->get();
        });

        return $domain_roles;
    }



    /**
     * @return int
     */
    public function domainRolesCount()
    {
        return $this->domainRoles()->count();
    }



    /**
     * @return array
     */
    public function domainRolesArray()
    {
        return $this->domainRoles()->pluck('slug')->toArray();
    }



    /**
     * @return string
     */
    public function getDomainRolePrefixAttribute()
    {
        return $this->domainRolePrefix();
    }



    /**
     * Gets domain role prefix from the config and adds a custom $additive
     *
     * @param string $additive
     *
     * @return string
     */
    public function domainRolePrefix(string $additive = '')
    {
        return config('yasna.role_prefix_for_domain_admins') . $additive;
    }
}
