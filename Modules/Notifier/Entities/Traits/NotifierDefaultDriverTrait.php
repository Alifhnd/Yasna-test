<?php

namespace Modules\Notifier\Entities\Traits;

use App\Models\Notifier;

trait NotifierDefaultDriverTrait
{
    /**
     * get formatted setting array from settings table
     *
     * @return array
     */
    private static function getDefaultDriversSetting()
    {
        $raw_string  = getSetting(static::DEFAULT_SETTING_SLUG);
        $raw_array   = explode_not_empty(",", $raw_string);
        $final_array = [];

        foreach ($raw_array as $item) {
            if (str_contains($item, ":")) {
                $channel = str_before($item, ':');
                $driver  = str_after($item, ':');

                $final_array[$channel] = $driver;
            }
        }

        return $final_array;
    }



    /**
     * set settings table from the formatted array
     *
     * @param array $channels
     *
     * @return bool
     */
    private static function setDefaultDriversSetting(array $channels)
    {
        $middle_array = [];
        foreach ($channels as $channel => $driver) {
            $middle_array[] = "$channel:$driver";
        }

        $raw_string = implode(",", $middle_array);

        return setting(static::DEFAULT_SETTING_SLUG)->setCustomValue($raw_string);
    }



    /**
     * get default driver of a specific channel
     *
     * @param string $channel
     *
     * @return string
     */
    public static function getDefaultDriverOf(string $channel)
    {
        $array = self::getDefaultDriversSetting();

        if (isset($array[$channel])) {
            return $array[$channel];
        }

        return "";
    }



    /**
     * find default driver of a specific channel
     *
     * @param string $channel
     *
     * @return Notifier
     */
    public static function locateDefaultDriverOf(string $channel)
    {
        $driver = static::getDefaultDriverOf($channel);
        $model  = notifier()::locate($channel, $driver);

        return $model;
    }



    /**
     * set default driver of a specific channel
     *
     * @param string $channel
     * @param string $driver
     *
     * @return bool
     */
    public static function setDefaultDriverOf(string $channel, string $driver)
    {
        $array           = static::getDefaultDriversSetting();
        $array[$channel] = $driver;

        return static::setDefaultDriversSetting($array);
    }
}
