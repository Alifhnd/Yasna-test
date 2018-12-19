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

if (!function_exists('manageStatus')) {
    /**
     * get manage status
     *
     * @param  string $status
     * @param string  $mood
     *
     * @deprecated as of 1397/6/6
     * @return string
     */
    function manageStatus($status, $mood = 'text')
    {
        switch ($mood) {
            case 'color':
                return config("manage.status.color.$status");
            case 'icon':
                return config("manage.status.icon.$status");
            case 'text':
                return trans("manage::forms.status_text.$status");
            default:
                return "what the hell is $mood? ";
        }
    }
}

if (!function_exists('classRemover')) {
    /**
     * ? (very old)
     *
     * @param string $str
     * @param string $target
     *
     * @deprecated as of 1397/6/6
     * @return string
     */
    function classRemover($str, $target)
    {
        $unfilteredArray = array_filter(explode(" ", $str));


        $filteredArray = array_filter($unfilteredArray, function ($item) use ($target) {
            return !starts_with($item, $target);
        });


        return implode(" ", $filteredArray);
    }
}

if (!function_exists('widget')) {

    /**
     * get an instance of the widget class
     *
     * @param string $widget_name
     *
     * @return \Modules\Manage\Services\Widget
     */
    function widget($widget_name = null)
    {
        return \Modules\Manage\Services\Widget::builder($widget_name);
    }
}

if (!function_exists('manage')) {

    /**
     * get an instance of manage helper
     *
     * @deprecated as of 1397/6/6
     * @return \Modules\Manage\Services\Helper
     */
    function manage()
    {
        return new \Modules\Manage\Services\Helper();
    }
}

if (!function_exists('form')) {

    /**
     * get an instance of the form generator class
     *
     * @return \Modules\Manage\Services\Form
     */
    function form()
    {
        return (new \Modules\Manage\Services\Form());
    }
}
