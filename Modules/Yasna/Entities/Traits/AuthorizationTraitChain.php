<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitChain
{
    private $as_role        = false;
    private $max_status     = 10;
    private $min_status     = 0;
    private $with_disableds = false;



    /**
     * Sets the necessary flag to take one/some of the roles in $this->roleQuery().
     *
     * @param string|array $requested_role
     *
     * @return $this
     */
    public function as($requested_role)
    {
        if (is_object($requested_role)) {
            $requested_role = $requested_role->slug;
        }

        if (is_string($requested_role)) {
            $special_method = strtolower($requested_role . "Roles");
            if ($this->hasMethod($special_method)) {
                $requested_role = $this->$special_method();
            }
        }

        $this->as_role = (array)$requested_role;
        return $this;
    }



    /**
     * Resets all chain methods
     *
     * @return $this
     */
    public function withDefaultChain()
    {
        $this->as_role        = false;
        $this->max_status     = 10;
        $this->min_status     = 0;
        $this->with_disableds = false;

        return $this;
    }



    /**
     * Gets an array of admin role slugs
     *
     * @return array
     */
    private function adminRoles()
    {
        return role()->adminRoles();
    }



    /**
     * Gets an array of all role slugs
     *
     * @return array
     */
    private function allRoles()
    {
        return role()->allRoles();
    }



    /**
     * A pretty shortcut to $this->as('all')
     *
     * @return $this
     */
    public function asAll()
    {
        return $this->as('all');
    }



    /**
     * @deprecated
     * @return $this
     */
    public function as_all()
    {
        return $this->asAll();
    }



    /**
     * A pretty shortcut to $this->as('admin')
     *
     * @return $this
     */
    public function asAdmin()
    {
        return $this->as('admin');
    }



    /**
     * A pretty and more meaningful shortcut to $this->as('all')
     *
     * @return $this
     */
    public function asAny()
    {
        return $this->asAll();
    }



    /**
     * @deprecated
     * @return $this
     */
    public function as_any()
    {
        return $this->asAny();
    }



    /**
     * A pretty shortcut to $this->as('manager')
     *
     * @return $this
     */
    public function asManager()
    {
        return $this->as('manager');
    }



    /**
     * @deprecated
     * @return $this
     */
    public function as_manager()
    {
        return $this->asManager();
    }



    /**
     * Sets the required flag to look into disabled roles too.
     *
     * @return $this
     */
    public function withDisableds()
    {
        $this->with_disableds = true;
        return $this;
    }



    /**
     * @deprecated
     * @return $this
     */
    public function includeDisabled()
    {
        return $this->withDisableds();
    }



    /**
     * A convenient shortcut to $this->withDisableds()
     *
     * @return $this
     */
    public function withDisabled()
    {
        return $this->withDisableds();
    }



    /**
     * Sets the necessary flag to consider a minimum status in $this->roleQuery().
     *
     * @param int $min_status
     *
     * @return $this
     */
    public function min(int $min_status = 1)
    {
        $this->min_status = $min_status;

        return $this;
    }



    /**
     * Sets the necessary flag to consider a maximum status in $this->roleQuery().
     *
     * @param int $max_status
     *
     * @return $this
     */
    public function max(int $max_status = 10)
    {
        $this->max_status = $max_status;

        return $this;
    }



    /**
     * This was bullshit in the first place.
     *
     * @deprecated
     * @return null
     */
    public function shh()
    {
        return null;
    }



    /**
     * @param string $var
     *
     * @deprecated
     * @return bool|int|string
     */
    public function getChain($var)
    {
        switch ($var) {
            case 'as':
            case 'as_role':
                return $this->as_role;
            case 'min':
            case 'min_status':
                return $this->min_status;
            case 'max':
            case 'max_status':
                return $this->max_status;
            case 'with_disableds':
            case 'include_disabled':
                return $this->with_disableds;
        }

        return 'unknown-chain';
    }
}
