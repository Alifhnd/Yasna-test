<?php

namespace Modules\Yasna\Entities\Traits;

trait AuthorizationTraitCan
{

    /**
     * Checks weather the use has a particular permission
     *
     * @param string $permit
     * @param int    $min_status
     *
     * @return bool
     */
    public function can($permit = '*', int $min_status = 8)
    {
        $permit = $this->correctCommonMistakes($permit);
        $permit = $this->considerWildcards($permit);

        if (!$this->as_role) {
            $this->as('admin');
        }

        if ($this->isDeveloper()) {
            return true;
        }

        if ($this->isSuperadmin() and not_in_array($permit, ['dev', 'developer'])) {
            return true;
        }

        if (!$this->exists) {
            return false;
        }

        if (!$permit) {
            return $this->hasAnyOfRoles();
        }

        return str_contains($this->mixedPermits($min_status), $permit);
    }



    /**
     * Pretty shortcut to the contrary of $this->can()
     *
     * @param string $permit
     * @param int    $min_status
     *
     * @return bool
     */
    public function cannot($permit = '*', int $min_status = 8)
    {
        return !$this->can($permit, $min_status);
    }



    /**
     * Pretty shortcut to the contrary of $this->can()
     *
     * @param string $permit
     * @param int    $min_status
     *
     * @return bool
     */
    public function cant($permit = '*', int $min_status = 8)
    {
        return !$this->can($permit, $min_status);
    }



    /**
     * Checks a number of permissions and returns true if one passed.
     *
     * @param array $permits
     * @param int   $min_status
     *
     * @return bool
     */
    public function canAny(array $permits, int $min_status = 8)
    {
        foreach ($permits as $permit) {
            if ($this->can($permit, $min_status)) {
                return true;
            }
        }

        return false;
    }



    /**
     * Checks a number of permissions and returns true if all passed.
     *
     * @param array $permits
     * @param int   $min_status
     *
     * @return bool
     */
    public function canAll(array $permits, int $min_status = 8)
    {
        foreach ($permits as $permit) {
            if ($this->cannot($permit, $min_status)) {
                return false;
            }
        }

        return true;
    }



    /**
     * @deprecated
     *
     * @param array $permits
     * @param int   $min_status
     *
     * @return bool
     */
    public function can_any(array $permits, int $min_status = 8)
    {
        return $this->canAny($permits, $min_status);
    }



    /**
     * @deprecated
     *
     * @param array $permits
     * @param int   $min_status
     *
     * @return bool
     */
    public function can_all(array $permits, int $min_status = 8)
    {
        return $this->canAll($permits, $min_status);
    }



    /**
     * Replaces all wildcards with an empty string
     *
     * @param string $request
     *
     * @return string
     */
    private function considerWildcards($request)
    {
        if (in_array($request, config('yasna.permission_wildcards'))) {
            $request = null;
        }

        foreach (config('yasna.permission_wildcards') as $wildcard) {
            $request = str_replace($wildcard, null, $request);
        }

        return $request;
    }



    /**
     * Corrects common mistakes in asking permissions, by replacing some strings
     *
     * @param string $request
     *
     * @return string
     */
    private function correctCommonMistakes($request)
    {
        $request = str_replace('post-', 'posts-', $request);
        $request = str_replace('comment-', 'comments-', $request);
        $request = str_replace('user-', 'users-', $request);
        $request = str_replace('settings', 'setting', $request);// <~~ to avoid double s at the end of `settings`
        $request = str_replace('setting', 'settings', $request);

        return trim($request);
    }



    /**
     * Mixes all available permissions, considering the requested role via $this->rolesQuery() and disabled roles via
     * the chain methods.
     *
     * @param int $min_status
     *
     * @return string
     */
    private function mixedPermits(int $min_status = 8)
    {
        $array = $this->min($min_status)->rolesQuery()->pluck('pivot.permissions')->toArray();

        return implode(' ', $array);
    }
}
