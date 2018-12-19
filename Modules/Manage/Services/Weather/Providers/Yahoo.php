<?php

namespace Modules\Manage\Services\Weather\Providers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Modules\Manage\Services\Weather\WeatherDriver;
use Modules\Manage\Services\Weather\WeatherInterface;


class Yahoo extends WeatherDriver implements WeatherInterface
{

    protected $latitude;
    protected $longitude;
    protected $state_id;



    /**
     * Yahoo constructor.
     *
     * @param integer $state_id
     * @param float   $latitude
     * @param float   $longitude
     */
    public function __construct($state_id, $latitude, $longitude)
    {
        $this->state_id  = $state_id;
        $this->latitude  = $latitude;
        $this->longitude = $longitude;
        $this->build();
    }



    /**
     *  Send rest request to https://query.yahooapis.com
     *
     * @return array
     */
    public function sendRequest()
    {
        $base_url      = "http://query.yahooapis.com/v1/public/yql";
        $yql_query     = 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="(' . $this->latitude . ', ' . $this->longitude . ')")';
        $yql_query_url = $base_url . "?q=" . urlencode($yql_query) . "&format=json";
        try {
            $client = new Client();
            $res    = $client->get($yql_query_url);
            if ($res->getStatusCode() == 200) {
                $data = json_decode($res->getBody(), true);
                if ($data and is_array($data) and isset($data['query']['results']['channel'])) {
                    $this->response = $data['query']['results']['channel'];
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
            $data['provider']       = 'Yahoo';
            $data['ip']             = request()->ip();
            $data['date']           = $date['formatted'];
            $data['country']        = $res['location']['country'] ?? null;
            $data['city']           = $state->title;
            $data['province']       = model('State')->grab($state->parent_id)->title;
            $data['wind.speed']     = $res['wind']['speed'] ?? null;
            $data['wind.direction'] = $res['wind']['direction'] ?? null;
            $data['lat']            = $res['item']['lat'] ?? null;
            $data['long']           = $res['item']['long'] ?? null;
            $data['sunrise']        = $res['astronomy']['sunrise'] ?? null;
            $data['sunset']         = $res['astronomy']['sunset'] ?? null;
            $data['temp']           = $this->calcTemp($res['item']['condition']['temp']);
            $data['temp_min']       = 1;
            $data['temp_max']       = 1;
            $data['pressure']       = $res['atmosphere']['pressure'] ?? null;
            $data['humidity']       = $res['atmosphere']['humidity'] ?? null;
            $data['status']         = $res['item']['condition']['text'] ?? null;
            $data['icon']           = '';
        }
        $this->data = $data;
    }



    /**
     * Convert celsius to fahrenheit temperature
     *
     * @param null $temp
     *
     * @return float|null
     */
    public function calcTemp($temp = null)
    {
        if ($temp) {
            return round(($temp - 32) * (5 / 9), 1);
        }
        return null;
    }


}
