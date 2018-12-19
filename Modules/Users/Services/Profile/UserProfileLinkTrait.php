<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/17/18
 * Time: 2:37 PM
 */

namespace Modules\Users\Services\Profile;


trait UserProfileLinkTrait
{
    /**
     * Returns the link of the user's profile which can be used in the manage area.
     *
     * @return string|null If the logged in user has not access to the user's profile, the link will be `null`.
     */
    public function link()
    {
        if ($this->isNotAvailable()) {
            return null;
        }

        return 'modal:' . route('user-profile', [
                  'hashid' => $this->user->hashid,
             ], false);
    }



    /**
     * Whether the user's profile is available for the logged in user.
     *
     * @return bool
     */
    public function isAvailable()
    {
        foreach ($this->permissions() as $permission) {
            if (user()->can($permission)) {
                return true;
            }
        }

        return false;
    }



    /**
     * Whether the user's profile is not available for the logged in user.
     *
     * @return bool
     */
    public function isNotAvailable()
    {
        return !$this->isAvailable();
    }



    /**
     * Returns an array of permissions to be check for availability of the user's profile.
     *
     * @return array
     */
    protected function permissions()
    {
        return array_map(function ($role) {
            return "users-$role.view";
        }, $this->user->rolesArray());
    }
}
