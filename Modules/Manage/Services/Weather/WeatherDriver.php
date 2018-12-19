<?php

namespace Modules\Manage\Services\Weather;


abstract class WeatherDriver
{
    protected $data     = [];
    protected $response = [];
    protected $latitude;
    protected $longitude;
    protected $state_id;



    /**
     * Weather constructor.
     *
     * @param bool $auto_handle
     */
    public function __construct($auto_handle = true)
    {
        if ($auto_handle) {
            $this->setLatLong();
            $this->handle();
        }
    }



    /**
     * Return the latitude that has been read from provider
     *
     * @return integer|null
     */
    public function getLatitude()
    {
        return $this->data['lat'] ?? null;
    }



    /**
     * Return the longitude that has been read from provider
     *
     * @return integer|null
     */
    public function getLongitude()
    {
        return $this->data['long'] ?? null;
    }



    /**
     * Return the temperature that has been read from provider
     *
     * @return int|null
     */
    public function getTemperature()
    {
        return $this->data['temp'] ?? null;
    }



    /**
     * Return the sunrise time
     *
     * @return string|null
     */
    public function GetSunrise()
    {
        return $this->data['sunrise'] ?? null;
    }



    /**
     * Return the sunset time
     *
     * @return string|null
     */
    public function getSunset()
    {
        return $this->data['sunset'] ?? null;
    }



    /**
     * Return the speed of wind
     *
     * @return int|float|null
     */
    public function getWindSpeed()
    {
        return $this->data['wind.speed'] ?? null;
    }



    /**
     * Return the humidity
     *
     * @return int|null
     */
    public function getHumidity()
    {
        return $this->data['humidity'] ?? null;
    }



    /**
     * Return the direction of wind
     *
     * @return int|null
     */
    public function getWindDirection()
    {
        return $this->data['wind.direction'] ?? null;
    }



    /**
     * Return all the values the online provider collected
     *
     * @return array
     */
    public function getData()
    {
        return $this->data ?? null;
    }



    /**
     * Return title of status
     *
     * @return string
     */
    public function getStatus()
    {
        $status = strtolower($this->data['status']);
        $key    = str_replace(' ', '_', $status);
        $titles = [
             'clear'                => trans('manage::dashboard.weather.clear'),
             'clear_day'            => trans('manage::dashboard.weather.clear'),
             'rainy'                => trans('manage::dashboard.weather.rainy'),
             'sunny'                => trans('manage::dashboard.weather.sunny'),
             'foggy'                => trans('manage::dashboard.weather.foggy'),
             'windy'                => trans('manage::dashboard.weather.windy'),
             'cloudy'               => trans('manage::dashboard.weather.cloudy'),
             'clouds'               => trans('manage::dashboard.weather.cloudy'),
             'partly_cloudy'        => trans('manage::dashboard.weather.partly_cloudy'),
             'partly_cloudy(day)'   => trans('manage::dashboard.weather.partly_cloudy(day)'),
             'partly_cloudy(night)' => trans('manage::dashboard.weather.partly_cloudy(night)'),
        ];
        return $titles[$key] ?? trans('manage::dashboard.weather.clear_day');
    }



    /**
     * Return iron of status
     *
     * @return string
     */
    public function getIcon()
    {
        // "clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy","rain", "sleet", "snow", "wind", "fog"
        $icon  = strtolower($this->data['status']);
        $key   = str_replace(' ', '_', $icon);
        $icons = [
             'clear'                => 'clear-day',
             'clear_day'            => 'clear-day',
             'clear_night'          => 'clear-night',
             'rainy'                => 'rain',
             'sunny'                => 'clear-day',
             'mostly_sunny'         => 'clear-day',
             'foggy'                => 'fog',
             'windy'                => 'wind',
             'cloudy'               => 'cloudy',
             'clouds'               => 'cloudy',
             'partly_cloudy'        => 'partly-cloudy-day',
             'partly_cloudy(day)'   => 'partly-cloudy-day',
             'partly_cloudy(night)' => 'partly-cloudy-night',
        ];
        return $icons[$key] ?? 'clear_day';
    }



    /**
     * Return the country name that has been read from provider
     *
     * @return string|null
     */
    public function getCountry()
    {
        return $this->data['country'] ?? null;
    }



    /**
     * Return the city name from states
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->data['city'] ?? null;
    }



    /**
     * Return the province name from states
     *
     * @return string|null
     */
    public function getProvince()
    {
        return $this->data['province'] ?? null;
    }



    /**
     * Return the date , when receive data from online provider
     *
     * @return date|null
     */
    public function getDate()
    {
        return $this->data['date'] ?? null;
    }



    /**
     * get current provider
     *
     * @return mixed|null
     */
    public function getProvider()
    {
        return $this->data['provider'] ?? null;
    }



    /**
     *  check isset lat
     */
    public function hasData()
    {
        if (count($this->data) && isset($this->data['lat'])) {
            return true;
        }
        return false;
    }


}
