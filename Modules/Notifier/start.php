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

if (!function_exists('notifier')) {
    /**
     * return a model instance
     *
     * @param int  $id_or_hashid
     * @param bool $with_trashed
     *
     * @return \App\Models\Notifier
     */
    function notifier($id_or_hashid = 0, $with_trashed = false)
    {
        return model('Notifier', $id_or_hashid, $with_trashed);
    }
}


if (!function_exists('databaseNotification')) {

    /**
     * Returns a new instance of the `Modules\Manage\Services\Notifications\NotificationsHelper` class.
     *
     * @return \Modules\Notifier\Services\Database\NotificationsHelper
     */
    function databaseNotification()
    {
        return new \Modules\Notifier\Services\Database\NotificationsHelper();
    }
}
