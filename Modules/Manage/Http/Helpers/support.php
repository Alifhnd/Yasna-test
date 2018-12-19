<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/23/18
 * Time: 11:42 AM
 */


if (!function_exists('yasnaSupport')) {

    /**
     * Returns an instance of the `Modules\Manage\Services\Support\SupportHandler` class
     * to be used for support API requests.
     *
     * @return \Modules\Manage\Services\Support\SupportHandler
     */
    function yasnaSupport()
    {
        return new \Modules\Manage\Services\Support\SupportHandler();
    }
}
