<?php
/**
 * Created by PhpStorm.
 * User: jafar
 * Date: 11/28/17
 * Time: 18:08
 */

namespace Modules\Yasna\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Routing\Router;

abstract class YasnaProvider extends ServiceProvider
{
    public static $listeners   = [];
    protected     $defer       = false;
    private       $providers   = [];
    private       $aliases     = [];
    private       $middlewares = [];
    private       $artisans    = [];



    /**
     * boot the provider
     *
     * @param Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        /*-----------------------------------------------
        | Standard Modular Loads ...
        */
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->bindViewComposers();
        $this->registerFactories();
        $this->registerMigrations();
        $this->registerDefaultAlias();

        /*-----------------------------------------------
        | Custom Index ...
        */
        if (module()->isInitialized()) {
            $this->index();
        }
        $this->duringBoot();

        /*-----------------------------------------------
        | Taha Developments to the Original Modular System ...
        */
        $this->registerAllMiddlewares($router);
        $this->registerAllProviders();
        $this->registerAllAliases();
        $this->registerAllArtisans();
        $this->registerPartialRoutes();


        /*-----------------------------------------------
        | After Boot ...
        */
        App::booted(function () {
            $this->afterBoot();
        });
    }



    /**
     * register the provider
     *
     * @return void
     */
    public function register()
    {
    }



    /**
     * provide an index of the custom methods must be executed DURING provider boot sequence, only when the modules are
     * initialized.
     *
     * @return void
     */
    public function index()
    {
        //Override the method in your module, if you need to add things.
    }



    /**
     * provide an index of the custom methods must be executed DURING provider boot sequence, even if the modules are
     * not yet initialized.
     *
     * @return void
     */
    public function duringBoot()
    {

    }



    /**
     * provide an index of the custom methods must be executed AFTER provider boot sequence.
     *
     * @return void
     */
    public function afterBoot()
    {
        //Override the method in your module, if you need to add things.
    }



    /**
     * get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Private Factory
    |--------------------------------------------------------------------------
    |
    */

    /**
     * add a default alis, using the camel case of module alis, pointing to the module main service provider.
     * Override this if you need not to do that, for a specific (better to be a really good) reason.
     *
     * @return void
     */
    protected function registerDefaultAlias()
    {
        return $this->addAlias(studly_case($this->moduleAlias()), $this->module()->provider());
    }



    /**
     * look through the private member $this->aliases and register each item as an alias.
     * $this->aliases, itself, can be filled via protected method $this->addAlias, herein defined.
     *
     * @return void
     */
    private function registerAllAliases()
    {
        foreach ($this->aliases as $alias => $original) {
            AliasLoader::getInstance()->alias($alias, $original);
        }
    }



    /**
     * look through the private member $this->providers and register each item.
     * $this->providers, itself, can be filled via protected method $this->addProvider, herein defined.
     *
     * @return void
     */
    private function registerAllProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
    }



    /**
     * look through the private member $this->middlewares and register each item as an alias.
     * $this->middlewares, itself, can be filled via protected method $this->addMiddleware, herein defined.
     *
     * @return void
     */
    private function registerAllMiddlewares($router)
    {
        foreach ($this->middlewares as $alias => $class) {
            if (method_exists($router, 'aliasMiddleware')) {
                $router->aliasMiddleware($alias, $class);
            } else {
                $router->middleware($alias, $class);
            }
        }
    }



    /**
     * look through the private member $this->artisans and register each item as an artisan console command.
     * $this->artisans, itself, can be filled via protected method $this->addArtisan, herein defined.
     *
     * @return void
     */
    private function registerAllArtisans()
    {
        $this->commands($this->artisans);
    }



    /**
     * register module views, based on the module lowercase name (original) and alias (Taha-Developed)
     *
     * @return void
     */
    private function registerViews()
    {
        $view_path   = resource_path('views/modules/' . $this->moduleLowerName());
        $source_path = $this->module()->getPath("Resources/views");
        $mapped      = [$view_path, $source_path];

        $this->publishes([$source_path => $view_path,]);
        $this->loadViewsFrom($mapped, $this->moduleLowerName());
        $this->loadViewsFrom($mapped, $this->moduleAlias());
    }



    /**
     * bind general view composers
     */
    private function bindViewComposers()
    {
        View::composer($this->moduleLowerName() . "::*", function ($view) {
            $view->with('__module', $this->module());
            $view->with('__module_name', $this->moduleName());
        });
    }



    /**
     * register module configs, based on the module lowercase name (original) and alias (Taha-Developed)
     *
     * @return void
     */
    private function registerConfig()
    {
        $source_path = $this->module()->getPath("Config/config.php");

        $this->publishes([
             $source_path => config_path($this->moduleLowerName() . '.php'),
        ], 'config');

        $this->mergeConfigFrom($source_path, $this->moduleLowerName());
        $this->mergeConfigFrom($source_path, $this->moduleAlias());
    }



    /**
     * register module migrations
     *
     * @return void
     */
    private function registerMigrations()
    {
        $path = $this->module()->getPath(__DIR__ . '/../Database/Migrations');
        $this->loadMigrationsFrom($path);
    }



    /**
     * register module translations, based on the module lowercase name (original) and alias (Taha-Developed)
     *
     * @return void
     */
    public function registerTranslations()
    {
        $published_path = resource_path('lang/modules/' . $this->moduleLowerName());

        if (is_dir($published_path)) {
            $this->loadTranslationsFrom($published_path, $this->moduleLowerName());
        } else {
            $path = $this->module()->getPath("Resources/lang");
            $this->loadTranslationsFrom($path, $this->moduleAlias());
            $this->loadTranslationsFrom($path, $this->moduleLowerName());
        }
    }



    /**
     * register an additional directory of factories.
     * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
     *
     * @return void
     */
    private function registerFactories()
    {
        $path = $this->module()->getPath("Database/factories");

        if (!app()->environment('production')) {
            app(Factory::class)->load($path);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Module Provider Helpers
    |--------------------------------------------------------------------------
    |
    */


    /**
     * fill the private property $this->middlewares, to be automatically used by $this->registerAllMiddlewares
     *
     * @param string $alias
     * @param string $class
     *
     * @return void
     */
    protected function addMiddleware($alias, $class)
    {
        $this->middlewares[$alias] = $class;
    }



    /**
     * fill the private property $this->aliases, to be automatically used by $this->registerAllAliases
     *
     * @param string $alias
     * @param string $class
     *
     * @return void
     */
    protected function addAlias($alias, $class)
    {
        $this->aliases[$alias] = $class;
    }



    /**
     * fill the private property $this->providers, to be automatically used by $this->registerAllProviders
     *
     * @param string $class
     *
     * @return void
     */
    protected function addProvider($class)
    {
        $this->providers[] = $class;
    }



    /**
     * fill the private property $this->artisans, to be automatically used by $this->registerAllArtisans
     *
     * @param string $class
     *
     * @return void
     */
    protected function addArtisan($class)
    {
        $this->artisans[] = $class;
    }



    /**
     * add schedule to the list of registered cron jobs
     *
     * @param string $class
     * @param bool   $name
     *
     * @return void
     */
    protected function addSchedule($class, $name = false)
    {
        module('yasna')
             ->service('schedules')
             ->add($name)
             ->class($class)
        ;
    }



    /**
     * add model trait
     *
     * @param string $trait_name
     * @param string $model_name
     *
     * @return void
     */
    protected function addModelTrait(string $trait_name, string $model_name)
    {
        $model_name = studly_case($model_name);
        $trait_name = studly_case($trait_name);
        if (!str_contains($trait_name, ":")) {
            $trait_name = $this->moduleName() . ":" . $trait_name;
        }

        module("yasna")
             ->service("traits")
             ->add($trait_name)
             ->trait($trait_name)
             ->to($model_name)
        ;
    }



    /**
     * register event-listeners.
     *
     * @param string $event_class
     * @param string $listener_class
     *
     * @return void
     */
    protected function listen($event_class, $listener_class)
    {
        $this->app['events']->listen($event_class, $listener_class);

        static::$listeners[$event_class] = $listener_class;
    }



    /**
     * discover and get the class_name
     * (As this YasnaProvider is supposed to be used only via module service providers)
     *
     * @return string
     */
    protected function className()
    {
        $name  = get_class($this);
        $array = explode("\\", $name);
        return array_last($array);
    }



    /**
     * discover and get the module name based on the name pattern: FolanServiceProvider
     *
     * @return string
     */
    protected function moduleName()
    {
        return str_before($this->className(), "ServiceProvider");
    }



    /**
     * get the module object
     *
     * @return ModuleHelper
     */
    protected function module()
    {
        return module($this->moduleName());
    }



    /**
     * get the module alias, stated in the module.json file.
     *
     * @return string
     */
    protected function moduleAlias()
    {
        return $this->module()->getAlias();
    }



    /**
     * get the module lowercase name, to be used mainly in view/trans/config finders
     *
     * @return string
     */
    protected function moduleLowerName()
    {
        return strtolower($this->moduleName());
    }



    /**
     * determine if the project is initialized (yasna:init)
     *
     * @return bool
     */
    protected function isInitialized()
    {
        return module()->isInitialized();
    }



    /**
     * determine if the project is NOT initialized (yasna:init)
     *
     * @return bool
     */
    protected function isNotInitialized()
    {
        return module()->isNotInitialized();
    }



    /**
     * register all the route files, situated in Http/Route directory
     *
     * @return void
     */
    protected function registerPartialRoutes()
    {
        $directory = $this->module()->getPath("Http") . DIRECTORY_SEPARATOR . "Routes" . DIRECTORY_SEPARATOR;
        if (!file_exists($directory)) {
            return;
        }


        $files = scandir($directory);
        foreach ($files as $file) {
            if (str_contains($file, ".php") and $file['0'] != '_') {
                $this->loadRoutesFrom($directory . $file);
            }
        }
    }
}
