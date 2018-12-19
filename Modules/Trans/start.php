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


if (!function_exists('dynamicTrans')) {
    /**
     * get trans from dynamic trans only
     *
     * @param string $key
     *
     * @return string
     */
    function dynamicTrans($key)
    {
        $obj = new \Modules\Trans\services\DynamicTrans($key);
        return $obj->getValue();
    }
}