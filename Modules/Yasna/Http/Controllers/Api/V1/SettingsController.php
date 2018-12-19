<?php

namespace Modules\Yasna\Http\Controllers\Api\V1;

use Modules\Yasna\Services\YasnaApiController;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends YasnaApiController
{
    /**
     * get a particular setting, provided that it is marked as api-discoverable
     *
     * @param string $slug
     *
     * @return array|Response
     */
    public function getSetting(string $slug)
    {
        $setting = setting($slug);
        if($setting->api_discoverable) {
            return $this->success($setting->gain(), $slug);
        }

        return $this->clientError(410);
    }



    /**
     * get all api-discoverable settings
     *
     * @return array
     */
    public function getAllSettings()
    {
        $settings = setting()::where('api_discoverable',1)->get();
        $array = [];

        foreach ($settings as $setting) {
            $array[$setting->slug] = $setting->gain();
        }

        return $this->success($array);
    }
}
