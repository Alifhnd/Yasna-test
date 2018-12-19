<?php

namespace Modules\Notifier\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait NotifierChannelsTrait
{
    /**
     * get a query builder of all defined channels
     *
     * @return Builder
     */
    public static function channels(): Builder
    {
        return notifier()->groupBy("channel");
    }



    /**
     * get a collection of all defined channels
     *
     * @return Collection
     */
    public static function getChannels(): Collection
    {
        return static::channels()->orderBy("channel")->get();
    }



    /**
     * get an array of all defined channels
     *
     * @return array
     */
    public static function getChannelsArray(): array
    {
        return static::getChannels()->pluck('channel')->toArray();
    }
}
