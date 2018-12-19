<?php

namespace Modules\Notifier\Http\Controllers;

use App\Models\Notifier;
use Illuminate\Http\Request;
use Modules\Notifier\Http\Requests\NotifierRequest;
use Modules\Yasna\Services\YasnaController;

class NotifierController extends YasnaController
{
    protected $base_model = 'notifier';



    /**
     * Return 'index' view.
     *
     * @return \Illuminate\Support\Facades\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $this->loadAssets();
        $view_data['channels'] = $this->loadChannels();
        $view_data['page']     = $this->setPage();
        return $this->view('notifier::setting.index', $view_data);
    }



    /**
     * set page title
     *
     * @return array
     */
    private function setPage()
    {
        return [
             ["notifier", trans('notifier::general.page')],
        ];
    }



    /**
     * Load channels.
     *
     * @return array
     */
    protected function loadChannels()
    {
        $result = [];

        foreach (notifier()::getChannelsArray() as $channel) {
            $result[$channel] = [
                 "title"          => title_case($channel),
                 "slug"           => $channel,
                 "name"           => strtolower($channel),
                 "drivers"        => $this->loadDrivers($channel),
                 "default_driver" => notifier()::getDefaultDriverOf($channel),
            ];
        }

        return $result;
    }



    /**
     * Load drivers.
     *
     * @param string $channel
     *
     * @return array
     */
    protected function loadDrivers($channel)
    {
        $result = [];

        foreach (notifier()::getDriversOf($channel) as $driver) {
            $result[] = [
                 "id"                   => $driver->id,
                 "title"                => $driver->title,
                 "slug"                 => $driver->slug,
                 "is_active"            => $driver->isActive(),
                 "available_for_admins" => $driver->available_for_admins,
                 "inputs"               => $driver->getDataArray(),
            ];
        }

        return $result;
    }



    /**
     * Load assets.
     */
    protected function loadAssets()
    {
        module('manage')
             ->service('template_assets')
             ->add('notifier-style')
             ->link("notifier:css/notifier.min.css")
             ->order(42)
        ;

        //module('manage')
        //     ->service('template_bottom_assets')
        //     ->add('notifier-js')
        //     ->link("notifier:js/notifier.min.js")
        //     ->order(42)
        //;
    }



    /**
     * Temporal save method.
     *
     * @param NotifierRequest $request
     */
    //public function save(NotifierRequest $request)
    //{
    //    $saved_data = batchSave($request);
    //}
}
