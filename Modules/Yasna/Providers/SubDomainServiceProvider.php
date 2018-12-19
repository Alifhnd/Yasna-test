<?php

namespace Modules\Yasna\Providers;

use Illuminate\Support\ServiceProvider;

class SubDomainServiceProvider extends ServiceProvider
{
    protected static $currentSubDomain;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function setDomain($domain)
    {
        self::$currentSubDomain = $domain;
    }

    public static function getDomain()
    {
        return self::$currentSubDomain;
    }
}
