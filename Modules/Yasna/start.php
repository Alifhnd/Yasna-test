<?php

require_once "Http/helpers.php";

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

if (!function_exists('setDomain')) {
    function setDomain($domain)
    {
        return SubDomain::setDomain($domain);
    }
}

if (!function_exists('getDomain')) {

    function getDomain()
    {
        return SubDomain::getDomain();
    }
}

if (!function_exists('job')) {

    /**
     * @return \App\Models\Job|\Modules\Yasna\Services\YasnaModel
     */
    function job()
    {
        return model('job');
    }
}

if (!function_exists('api')) {

    /**
     * @param null $standard
     *
     * @return \Modules\Yasna\Services\Responders\ApiResponseInterface
     */
    function api($standard = null)
    {
        $file   = debug_backtrace()[0]['file'];
        $module = str_before(str_after($file, "Modules/"), "/");
        $object = \Modules\Yasna\Services\Responders\ApiResponseAbstract::init($standard);
        $object::setModuleName($module);

        return $object;
    }
}

if (!function_exists('role')) {

    /**
     * @param string|int $id_or_slug
     * @param bool       $with_trashed
     *
     * @return \App\Models\Role
     */
    function role($id_or_slug = 0, bool $with_trashed = false)
    {
        return model('role', $id_or_slug, $with_trashed);
    }
}

if (!function_exists('build_url')) {

    /**
     * @param array $parts
     *
     * @return string
     */
    function build_url(array $parts)
    {
        $scheme   = isset($parts['scheme']) ? ($parts['scheme'] . '://') : '';
        $host     = $parts['host'] ?? '';
        $port     = isset($parts['port']) ? (':' . $parts['port']) : '';
        $user     = $parts['user'] ?? '';
        $pass     = isset($parts['pass']) ? (':' . $parts['pass']) : '';
        $pass     = ($user || $pass) ? ($pass . '@') : '';
        $path     = $parts['path'] ?? '';
        $query    = isset($parts['query']) ? ('?' . $parts['query']) : '';
        $fragment = isset($parts['fragment']) ? ('#' . $parts['fragment']) : '';

        return implode('', [$scheme, $user, $pass, $host, $port, $path, $query, $fragment]);
    }
}


if (!function_exists('domain')) {

    /**
     * @param string|int $id_or_slug
     * @param bool       $with_trashed
     *
     * @return \App\Models\Domain
     */
    function domain($id_or_slug = 0, bool $with_trashed = false)
    {
        return model('domain', $id_or_slug, $with_trashed);
    }
}


if (!function_exists('phone_format')) {
    /**
     * make readable phone number
     *
     * @param string $phone
     *
     * @return string
     */
    function phone_format($phone)
    {
        if (strlen($phone) != 11) {
            $phone = "0" . $phone;
        }
        $code     = substr($phone, 0, 4);
        $three    = substr($phone, 4, 3);
        $lastFour = substr($phone, 7, 4);
        $phone    = $lastFour . " " . $three . " " . $code;
        return $phone;
    }
}
