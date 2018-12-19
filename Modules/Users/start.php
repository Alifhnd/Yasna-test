<?php

/*
|--------------------------------------------------------------------------
| Register Namespaces And Routes
|--------------------------------------------------------------------------
|
| When a module starting, this file will executed automatically. This helps
| to register some namespaces like translator or view. Also this file
| will load the routes file for each module. You may also modify
| this file as you want.
|
*/

if (!app()->routesAreCached()) {
    require __DIR__ . '/Http/routes.php';
}


if (!function_exists('userProfile')) {

    /**
     * Returns an instance of the `Modules\Users\Services\Profile\UserProfile` class
     * to be used for actions about the user profile.
     *
     * @param \App\Models\User|null $user
     *
     * @return \Modules\Users\Services\Profile\UserProfile
     */
    function userProfile(?\App\Models\User $user = null)
    {
        return new \Modules\Users\Services\Profile\UserProfile($user);
    }
}
