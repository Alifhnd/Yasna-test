<?php

namespace Modules\Manage\Services\Weather\Providers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Modules\Manage\Services\Weather\WeatherDriver;
use Modules\Manage\Services\Weather\WeatherInterface;
use Morilog\Jalali\jDate;


class OpenWeatherMap extends WeatherDriver implements WeatherInterface
{

    protected $latitude;
    protected $longitude;
    protected $state_id;
    protected $app_id;



    /**
     * OpenWeatherMap constructor.
     *
     * @param integer $state_id
     * @param float   $latitude
     * @param float   $longitude
     */
    public function __construct($state_id, $latitude, $longitude)
    {
        $this->app_id    = config('manage.open_weather_map_api_id');
        $this->state_id  = $state_id;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->build();
    }



    /**
     * Send rest request to http://api.openweathermap.org/data/2.5/weather
     * http://api.openweathermap.org/data/2.5/weather?lat=32&lon=51&appid=your_app_id
     * 60 request per minute free
     *
     * @return array
     */
    public function sendRequest()
    {
        $latitude  = (int)substr($this->latitude, 0, 2);
        $longitude = (int)substr($this->longitude, 0, 2);
        $url       = "http://api.openweathermap.org/data/2.5/weather?lat=" . $latitude . "&lon=" . $longitude . "&appid=" . $this->app_id;
        try {
            $client = new Client();
            $res    = $client->get($url);
            if ($res->getStatusCode() == 200) {
                $data = json_decode($res->getBody(), true);
                if ($data and is_array($data) and isset($data['weather'])) {
                    $this->response = $data;
                }
            }
        } catch (\Exception $e) {
            $this->response = [];
        }
        return $this->response;
    }



    /**
     * Uniform data structure
     *
     * @return array|null|void
     */
    public function build()
    {
        $state = model('State')->grab($this->state_id);
        $date  = Carbon::now()->toArray();
        $data  = [];
        $res   = $this->sendRequest();
        if (count($res)) {
            $data['provider']       = 'OpenWeatherMap';
            $data['ip']             = request()->ip();
            $data['date']           = $date['formatted'];
            $data['country']        = $res['sys']['country'] ?? null;
            $data['city']           = $state->title;
            $data['province']       = model('State')->grab($state->parent_id)->title;
            $data['wind.speed']     = $res['wind']['speed'] ?? null;
            $data['wind.direction'] = $res['wind']['deg'] ?? null;
            $data['lat']            = $res['coord']['lat'] ?? null;
            $data['long']           = $res['coord']['lon'] ?? null;
            $data['sunrise']        = jDate::forge($res['sys']['sunrise'])->format('h:i a') ?? null;
            $data['sunset']         = jDate::forge($res['sys']['sunset'])->format('h:i a') ?? null;
            $data['temp']           = $this->calcTemp($res['main']['temp']);
            $data['temp_min']       = $this->calcTemp($res['main']['temp_min']);
            $data['temp_max']       = $this->calcTemp($res['main']['temp_max']);
            $data['pressure']       = $res['main']['pressure'] ?? null;
            $data['humidity']       = $res['main']['humidity'] ?? null;
            $data['status']         = $res['weather'][0]['main'] ?? null;
            $data['icon']           = $res['weather'][0]['icon'] ?? null;
        } else {
            $data = [];
        }

        $this->data = $data;
    }



    /**
     * Convert kelvin to celsius temperature
     *
     * @param float|null $temp
     *
     * @return float|null
     */
    public function calcTemp($temp = null)
    {
        if ($temp) {
            return round(($temp - 273.15), 1);
        }
        return null;
    }


}
