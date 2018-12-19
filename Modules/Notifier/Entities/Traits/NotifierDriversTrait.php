<?php

namespace Modules\Notifier\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait NotifierDriversTrait
{
    /**
     * get a query builder of the drivers of a specific channel
     *
     * @param string $channel
     *
     * @return Builder
     */
    public static function driversOf(string $channel): Builder
    {
        return notifier()->where("channel", $channel);
    }



    /**
     * get an eloquent collection of the drivers of a specific channel
     *
     * @param string $channel
     *
     * @return Collection
     */
    public static function getDriversOf(string $channel): Collection
    {
        return static::driversOf($channel)->orderBy("driver")->get();
    }



    /**
     * get an array of the drivers of a specific channel
     *
     * @param string $channel
     *
     * @return array
     */
    public static function getDriversArrayOf(string $channel): array
    {
        return static::getDriversOf($channel)->pluck("driver")->toArray();
    }
}
