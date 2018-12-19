<?php

namespace Modules\Manage\Services\Weather\Providers;

use Carbon\Carbon;
use Modules\Manage\Services\Weather\WeatherDriver;


class DefaultProvider extends WeatherDriver
{

    protected $state_id;



    /**
     * DefaultProvider constructor.
     *
     * @param integer $state_id
     */
    public function __construct($state_id)
    {
        $this->state_id = $state_id;
        $this->build();
    }



    /**
     * Uniform data structure
     *
     * @return array|null|void
     */
    public function build()
    {
        $state = model('State')->grab($this->state_id);

        $date                   = Carbon::now()->toArray();
        $data                   = [];
        $data['ip']             = request()->ip();
        $data['date']           = $date['formatted'];
        $data['country']        = $state->weather['country'] ?? null;
        $data['city']           = $state->weather['city'] ?? null;
        $data['province']       = $state->weather['province'] ?? null;
        $data['wind.speed']     = $state->weather['wind.speed'] ?? null;
        $data['wind.direction'] = $state->weather['wind.direction'] ?? null;
        $data['lat']            = $state->weather['lat'] ?? null;
        $data['long']           = $state->weather['long'] ?? null;
        $data['sunrise']        = $state->weather['sunrise'] ?? null;
        $data['sunset']         = $state->weather['sunset'] ?? null;
        $data['temp']           = $state->weather['temp'] ?? null;
        $data['temp_min']       = $state->weather['temp_min'] ?? null;
        $data['temp_max']       = $state->weather['temp_max'] ?? null;
        $data['pressure']       = $state->weather['pressure'] ?? null;
        $data['humidity']       = $state->weather['humidity'] ?? null;
        $data['status']         = $state->weather['status'] ?? null;
        $data['icon']           = $state->weather['icon'] ?? null;
        $this->data             = $data;
    }

}
