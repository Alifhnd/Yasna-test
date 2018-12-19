<?php

namespace Modules\Trans\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Translation\TranslationServiceProvider as BaseTranslationProvider;
use Modules\Trans\services\YasnaTranslator;

class TranslationServiceProvider extends BaseTranslationProvider
{
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
        if (!$this->checkDependency()) {
            return;
        }

        $this->registerLoader();
        $this->app->bind('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $trans  = new YasnaTranslator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            if ($app->bound('translation-manager')) {
                $trans->setTranslationManager($app['translation-manager']);
            }
            return $trans;
        });

        $this->reloadPreviousModules();
    }



    /**
     * check dependency of binding translate
     *
     * @return bool
     */
    private function checkDependency(): bool
    {
        if (module('trans')->isNotInitialized()) {
            return false;
        }
        if (app()->runningInConsole() and !Schema::hasTable('translations')) {
            return false;
        }

        return true;
    }



    /**
     *TODO : this method create because  modules that create before of trans not loaded correctly this is'nt best solution it just reload previous modules
     */
    private function reloadPreviousModules()
    {
        foreach (module()->list() as $item) {
            if ($item == 'Trans') {
                break;
            }
            module($item)->getProvider()->registerTranslations();
        }
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
