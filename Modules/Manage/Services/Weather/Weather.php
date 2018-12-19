<?php

namespace Modules\Manage\Services\Weather;

use Carbon\Carbon;
use Modules\Manage\Services\Weather\Providers\DefaultProvider;

class Weather
{
    protected $object;
    protected $providers = ['Yahoo', 'OpenWeatherMap'];
    protected $data      = [];
    protected $latitude;
    protected $longitude;
    protected $state_id;



    /**
     * Weather constructor.
     */
    public function __construct()
    {
        $this->setLatLong();
        $this->handle();
    }



    /**
     * set latitude and longitude
     */
    public function setLatLong()
    {
        $state    = model('state');
        $state_id = (int)user()->preference('state_id') ?? user()->city ?? null;
        if (in_array($state_id, $state->pluck('id')->toArray())) {
            $state           = $state->where('id', $state_id)->first();
            $this->latitude  = $state->latitude;
            $this->longitude = $state->longitude;
            $this->state_id  = $state_id;
        } else {
            $state           = model('state')->where('id', 81)->first();
            $this->latitude  = $state->latitude;
            $this->longitude = $state->longitude;
            $this->state_id  = $state->id;
            user()->setPreference('state_id', $state->id);
        }
    }



    /**
     * handle the providers
     */
    public function handle()
    {
        $latitude  = $this->latitude;
        $longitude = $this->longitude;
        $state_id  = $this->state_id;

        if (!$this->stateHasWeather()) {
            foreach ($this->providers() as $provider) {
                $namespace       = "Modules\Manage\Services\Weather\Providers";
                $full_class_name = $namespace . "\\" . $provider;
                $object          = new $full_class_name($state_id, $latitude, $longitude);
                if ($object->hasData()) {
                    $this->object = $object;
                    $this->updateProvidersOrder($object->getProvider());
                    $this->updateStateWeather($this->object->getData());
                    break;
                }
            }
        } else {
            $this->object = new DefaultProvider($state_id);
        }
    }



    /**
     * Check the current state ,has weather in meta
     *
     * @return bool
     */
    public function stateHasWeather()
    {
        $state     = model('State')->grab($this->state_id);
        $weather   = $state->weather;
        $latitude  = $state->latitude;
        $yesterday = Carbon::now()->subHour(6);
        if ($latitude && $weather && isset($weather['date']) && !is_null($weather['date']) && $yesterday < $weather['date']) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * call method from specified object
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (substr($method, 0, 3) == 'get' && method_exists($this->object, $method)) {
            $object = $this->object;
            return $object->$method();
        }
    }



    /**
     * update order of providers
     *
     * @param string $provider
     */
    public function updateProvidersOrder($provider)
    {
        $providers = setting('weather_providers')->noCache()->gain()[0] ?? implode('|', $this->providers);
        $providers = (array)explode('|', $providers);
        $providers = array_diff($providers, [$provider]);
        $providers = array_prepend($providers, $provider);
        setting('weather_providers')->setValue(implode('|', $providers));
    }



    /**
     * Return list of providers
     *
     * @return array
     */
    public function providers()
    {
        if (isset(getSetting('weather_providers')[0])) {
            $weather_providers = setting('weather_providers')->gain()[0];
            return (array)explode('|', $weather_providers);
        }

        return $this->providers;
    }



    /**
     * Update weather in specified state
     *
     * @param array $data
     */
    public function updateStateWeather($data)
    {
        $state = model('State')->grab($this->state_id);
        user()->setPreference('state_id', $this->state_id);
        $state->update([
             'meta' => [
                  'latitude'  => $state->latitude,
                  'longitude' => $state->longitude,
                  'weather'   => $data ?? null,
             ],
        ]);
    }



    /**
     *  check isset lat
     */
    public function hasData()
    {
        if (is_object($this->object) and $this->object->hasData()) {
            return true;
        }

        return false;
    }



    /**
     * Return the city name from states
     *
     * @return string
     */
    public function cityName()
    {
        return model('State')->grab($this->state_id)->title;
    }



    /**
     * Return the province name from states
     *
     * @return string
     */
    public function provinceName()
    {
        $state = model('State')->grab($this->state_id);
        return model('State')->grab($state->parent_id)->title;
    }

}
