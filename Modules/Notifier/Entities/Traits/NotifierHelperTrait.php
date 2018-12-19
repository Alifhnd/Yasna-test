<?php

namespace Modules\Notifier\Entities\Traits;

trait NotifierHelperTrait
{
    /**
     * generate a model-wide standard unique slug, based on the channel and driver
     *
     * @param string $channel
     * @param string $driver
     *
     * @return string
     */
    public static function generateSlug(string $channel, string $driver): string
    {
        return "$channel:$driver";
    }



    /**
     * generate a good automatic human-readable title, based on the channel and driver
     *
     * @param string $channel
     * @param string $driver
     *
     * @return string
     */
    public static function generateTitle(string $channel, string $driver): string
    {
        return title_case("$driver $channel Notifier");
    }
}
