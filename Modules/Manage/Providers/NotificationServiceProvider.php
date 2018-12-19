<?php

namespace Modules\Manage\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;

class NotificationServiceProvider extends ServiceProvider
{
    use ModuleRecognitionsTrait;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;



    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }



    /**
     * boot the provider
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->registerNotificationGroups();
    }



    /**
     * Registers default notification groups.
     */
    protected function registerNotificationGroups()
    {
        $groups = $this->runningModule()->getConfig('notifications.groups');

        foreach ($groups as $group => $info) {
            databaseNotification()->registerNotificationGroup($group, $info);
        }
    }
}
