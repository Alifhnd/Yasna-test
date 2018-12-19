<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitRolesCheck
{
    /**
     * Checks if the current user as the requested role(s)
     *
     * @param array|string $role_slug : Chain property is used, if not provided.
     * @param bool         $any_of_them
     *
     * @return bool
     */
    public function hasRole($role_slug = null, bool $any_of_them = false)
    {
        $user = clone $this;

        if (is_string('role_slug') and in_array($role_slug, ['dev', 'developer'])) {
            return $user->isDeveloper();
        }

        if (is_string('role_slug') and $role_slug == 'admin') {
            return $user->isAdmin();
        }

        if ($role_slug) {
            $user->as($role_slug);
        }
        if (!$user->as_role) {
            return false;
        }

        $count = $user->rolesQuery()->count();


        if ($any_of_them) {
            return boolval($count);
        }

        return boolval($count == count($user->as_role));
    }



    /**
     * Useful shortcut to $this->hasRole(), with $any_of_them set to true.
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function hasAnyOfRoles($role_slug = null)
    {
        return $this->hasRole($role_slug, true);
    }



    /**
     * pretty shortcut to the contrary of $this->hasRole()
     *
     * @param null $role_slug
     * @param bool $any_of_them
     *
     * @return bool
     */
    public function hasnotRole($role_slug = null, bool $any_of_them = false)
    {
        return !$this->hasRole($role_slug, $any_of_them);
    }



    /**
     * A pretty shortcut for $this->hasRole()
     * It's most efficient for checking one role only.
     * Chain property is not supported herein.
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function is($role_slug)
    {
        return $this->hasRole($role_slug);
    }



    /**
     * Pretty shortcut to the contrary of $this->is()
     *
     * @param $role_Slug
     *
     * @return bool
     */
    public function isNot($role_Slug)
    {
        return !$this->is($role_Slug);
    }



    /**
     * A pretty shortcut for $this->hasRole().
     * It's most efficient for checking one role only.
     * Chain property is not supported herein.
     *
     * @param array ...$requested_roles
     *
     * @return bool (true if the user has any of the roles)
     */
    public function isAnyOf(... $requested_roles)
    {
        if (is_array($requested_roles[0])) {
            $requested_roles = $requested_roles[0];
        }
        return $this->hasRole($requested_roles, true);
    }



    /**
     * Pretty shortcut to $this->isAnyOf()
     *
     * @param array ...$requested_roles
     *
     * @return bool
     */
    public function isNotAnyOf(... $requested_roles)
    {
        return !$this->isAnyOf($requested_roles);
    }



    /**
     * A pretty shortcut for $this->hasRole().
     * It's most efficient for checking one role only.
     * Chain property is not supported herein.
     *
     * @param array ...$requested_roles
     *
     * @return bool
     */
    public function isAllOf(... $requested_roles)
    {
        if (is_array($requested_roles[0])) {
            $requested_roles = $requested_roles[0];
        }
        return $this->hasRole($requested_roles, false);
    }



    /**
     * Pretty shortcut to $this->isAllOf()
     *
     * @param array ...$requested_roles
     *
     * @return bool
     */
    public function isNoneOf(... $requested_roles)
    {
        return !$this->isAllOf($requested_roles);
    }



    /**
     * Checks if the user is attached to one of the 'admin' roles, found by Role::adminRoles()
     *
     * @return bool
     */
    public function isAdmin()
    {
        return dev() or $this->isAnyOf(role()->adminRoles());
    }



    /**
     * @deprecated
     * @return bool
     */
    public function is_admin()
    {
        return $this->isAdmin();
    }



    /**
     * @return bool
     */
    public function isSuperadmin()
    {
        return $this->isDeveloper() or $this->hasRole('superadmin');
    }



    /**
     * @return bool
     */
    public function isSuper()
    {
        return $this->isSuperadmin();
    }



    /**
     * @deprecated
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function is_a($role_slug)
    {
        return $this->hasRole($role_slug);
    }



    /**
     * @deprecated
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function is_an($role_slug)
    {
        return $this->hasRole($role_slug);
    }



    /**
     * @deprecated
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function is_not_a($role_slug)
    {
        return $this->hasnotRole($role_slug);
    }



    /**
     * @deprecated
     *
     * @param string $role_slug
     *
     * @return bool
     */
    public function is_not_an($role_slug)
    {
        return $this->hasnotRole($role_slug);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_one_of($role_slugs)
    {
        return $this->isAnyOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_any_of($role_slugs)
    {
        return $this->isAnyOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_not_one_of($role_slugs)
    {
        return $this->isNotAnyOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_not_any_of($role_slugs)
    {
        return $this->isNotAnyOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_all_of($role_slugs)
    {
        return $this->isAllOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_not_all_of($role_slugs)
    {
        return $this->isNoneOf($role_slugs);
    }



    /**
     * @deprecated
     *
     * @param $role_slugs
     *
     * @return bool
     */
    public function is_none_of($role_slugs)
    {
        return $this->isNoneOf($role_slugs);
    }



    /**
     * Checks if the role, passed via the chain method, is enabled.
     * The first role is checked only.
     *
     * @return bool
     */
    public function isEnabled()
    {
        $role = $this->firstRole();

        if (!$role or !$role['id'] or !$this->as_role) {
            return false;
        }

        return !boolval($role['pivot']['deleted_at']);
    }



    /**
     * @deprecated
     * @return bool
     */
    public function enabled()
    {
        return $this->isEnabled();
    }



    /**
     * shortcut to the contrary of $this->isEnabled()
     *
     * @return bool
     */
    public function isDisabled()
    {
        return !$this->isEnabled();
    }



    /**
     * @deprecated
     * @return bool
     */
    public function disabled()
    {
        return $this->isDisabled();
    }
}
