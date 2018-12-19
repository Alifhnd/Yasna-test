<?php

namespace Modules\Notifier\Providers;

use Illuminate\Routing\Router;
use Modules\Notifier\Console\MakeNotification;
use Modules\Notifier\Http\Middleware\NotificationMiddleware;
use Modules\Yasna\Services\YasnaProvider;

/**
 * Class NotifierServiceProvider
 *
 * @package Modules\Notifier\Providers
 */
class NotifierServiceProvider extends YasnaProvider
{
    /**
     * This will be automatically loaded in the app boot sequence if the module is active.
     *
     * @return void
     */
    public function index()
    {
        $this->registerModelTraits();
        $this->registerArtisanCommands();
        $this->registerSidebar();
        $this->registerServices();
    }



    /**
     * @inheritdoc
     */
    public function boot(Router $router)
    {
        parent::boot($router);

        $this->registerAutoMiddleware($router);
    }



    /**
     * register model traits
     */
    protected function registerModelTraits()
    {
        module('yasna')->service('traits')->add("UserNotifyTrait")->trait('Notifier:UserNotifyTrait')->to('User');
    }



    /**
     * register artisan commands
     */
    protected function registerArtisanCommands()
    {
        $this->addArtisan(MakeNotification::class);
    }



    /**
     * registers sidebar nested link under setting
     */
    protected function registerSidebar()
    {
        service('manage:settings_sidebar')
             ->add('notifier-setting')
             ->link('notifier')
             ->caption(trans("notifier::general.notifiers"))
             ->order(4)
             ->condition(function () {
                 return user()->isSuperadmin();
             })
        ;
    }



    /**
     * Registers Services
     */
    protected function registerServices()
    {
        $this
             ->module()
             ->register("notification_groups", "Groups of notifications to be used in the notifications' preview.")
        ;
    }



    /**
     * Adds the notification middleware to the `web` group.
     *
     * @param Router $router
     */
    protected function registerAutoMiddleware(Router $router)
    {
        $router->pushMiddlewareToGroup('web', NotificationMiddleware::class);
    }
}
