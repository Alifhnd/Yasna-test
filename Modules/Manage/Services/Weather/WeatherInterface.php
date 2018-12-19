<?php

namespace Modules\Manage\Services\Weather;


interface WeatherInterface
{

    /**
     * Send rest request to provider
     *
     * @return array
     */
    public function sendRequest();



    /**
     * Uniform data structure
     *
     * @return array|null
     */
    public function build();
}
