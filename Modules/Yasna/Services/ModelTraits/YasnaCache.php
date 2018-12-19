<?php namespace Modules\Yasna\Services\ModelTraits;

trait YasnaCache
{
    /**
     * UNFINISHED TRY!
     */
    public static function bootYasnaCache()
    {
        chalk()->add('Booted Yasna Cache') ;
        static::addGlobalScope(new YasnaCacheScope);
    }
}
