<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitFirstRole
{
    /**
     * Gets the first role-pivot row, based on the conditions passed by chains, preferably including the disabled roles.
     *
     * @param $with_disabled
     *
     * @return array
     */
    private function firstRole(bool $with_disabled = true)
    {
        if ($with_disabled) {
            return $this->withDisabled()->rolesQuery()->first();
        }

        return $this->rolesQuery()->first();
    }



    /**
     * Gets pivot key of the first role, passed by chain methods
     *
     * @param string $key
     *
     * @return string|integer
     */
    private function pivot($key = '')
    {
        if ($key) {
            return $this->firstRole()['pivot'][$key];
        }

        return $this->firstRole()['pivot'];
    }



    /**
     * Gets the title of the first role, requested by chain methods.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->firstRole()['title'];
    }



    /**
     * @deprecated
     * @return string
     */
    public function title()
    {
        return $this->getTitle();
    }



    /**
     * Gets status text of the first role, selected by chain methods.
     *
     * @TODO: It's not a proper place for this method.
     * @return string
     */
    public function statusText()
    {
        $role_id = $this->firstRole()['pivot']['role_id'];
        $role    = role($role_id);

        if ($role->isNotSet()) {
            return 'unknown';
        } elseif ($this->isDisabled()) {
            return 'banned';
        }

        return $role->statusText($this->getStatus());
    }
}
