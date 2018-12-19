<?php

namespace Modules\Yasna\Providers;

use AlbertCht\InvisibleReCaptcha\InvisibleReCaptchaServiceProvider;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Modules\Yasna\Console\DummyCommand;
use Modules\Yasna\Console\FlushInitCacheCommand;
use Modules\Yasna\Console\ListCommand;
use Modules\Yasna\Console\MakeBlade;
use Modules\Yasna\Console\MakeControllerCommand;
use Modules\Yasna\Console\MakeEventCommand;
use Modules\Yasna\Console\MakeListenerCommand;
use Modules\Yasna\Console\MakeModelCommand;
use Modules\Yasna\Console\MakeMigrationCommand;
use Modules\Yasna\Console\MakeModelTraitCommand;
use Modules\Yasna\Console\MakeModule;
use Modules\Yasna\Console\MakeRouteCommand;
use Modules\Yasna\Console\MakeScheduleCommand;
use Modules\Yasna\Console\ModuleDisableCommand;
use Modules\Yasna\Console\ModuleEnableCommand;
use Modules\Yasna\Console\CheckMigrationCommand;
use Modules\Yasna\Console\DocCommand;
use Modules\Yasna\Console\RouteListCommand;
use Modules\Yasna\Console\TransDiff;
use Modules\Yasna\Http\Middleware\CanMiddleware;
use Modules\Yasna\Http\Middleware\IsMiddleware;
use Modules\Yasna\Http\Middleware\SubDomainMiddleware;
use Modules\Yasna\Schedules\RepositionFavIconSchedule;
use Modules\Yasna\Services\YasnaProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Modules\Yasna\Console\AssetsShortcutsCommand;
use Modules\Yasna\Console\DevResetCommand;
use Modules\Yasna\Console\InitCommand;
use Modules\Yasna\Console\MakeRequestCommand;
use Modules\Yasna\Console\MakeTrans;
use Modules\Yasna\Console\Reseed;
use Modules\Yasna\Console\ServicesCommand;
use Modules\Yasna\Console\TestTrans;
use Modules\Yasna\Console\Truncate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Yasna\Services\YasnaSeedingTool;

class YasnaServiceProvider extends YasnaProvider
{
    /**
     * @inheritdoc
     */
    public function index()
    {
        $this->registerAliases();
        $this->registerProviders();
        $this->registerServices();
        $this->registerErrors();
        $this->registerMiddlewares();
        $this->registerSchedules();
    }



    /**
     * @inheritdoc
     */
    public function register()
    {
        parent::register();

        $this->bindPublicPath();
    }



    /**
     * @inheritdoc
     */
    public function duringBoot()
    {
        $this->registerArtisans();
        $this->setAppUrlForConsole();
    }



    /**
     * @inheritdoc
     */
    public function afterBoot()
    {
        $this->setReCaptchaConfigs();
    }



    /**
     * register aliases of this module
     */
    public function registerAliases()
    {
        $this->addAlias("Yasna", YasnaServiceProvider::class);
        $this->addAlias("SubDomain", SubDomainServiceProvider::class);
    }



    /**
     * register additional providers of this module
     */
    protected function registerProviders()
    {
        $this->addProvider(ValidationServiceProvider::class);
        $this->addProvider(InvisibleReCaptchaServiceProvider::class);
    }



    /**
     * register service environments
     */
    public function registerServices()
    {
        module('yasna')
             ->register('traits',
                  "Traits, to be added to other module's models, upon running of Yasna:init artisan command.")
             ->register('errors', "Indicates the blades, responsible for each error.")
             ->register('schedules', "Cron Jobs")
        ;
    }



    /**
     * register error blades
     */
    public function registerErrors()
    {
        module('yasna')
             ->service('errors')
             ->add('404')
             ->blade('yasna::errors.404')
        ;
    }



    /**
     * register artisans
     */
    public function registerArtisans()
    {
        $this->addArtisan(InitCommand::class);
        $this->addArtisan(ServicesCommand::class);
        $this->addArtisan(MakeTrans::class);
        $this->addArtisan(TestTrans::class);
        $this->addArtisan(DevResetCommand::class);
        $this->addArtisan(Truncate::class);
        $this->addArtisan(Reseed::class);
        $this->addArtisan(AssetsShortcutsCommand::class);
        $this->addArtisan(MakeRequestCommand::class);
        $this->addArtisan(MakeScheduleCommand::class);
        $this->addArtisan(DummyCommand::class);
        $this->addArtisan(MakeControllerCommand::class);
        $this->addArtisan(MakeListenerCommand::class);
        $this->addArtisan(MakeEventCommand::class);
        $this->addArtisan(MakeModelTraitCommand::class);
        $this->addArtisan(MakeModelCommand::class);
        $this->addArtisan(MakeBlade::class);
        $this->addArtisan(FlushInitCacheCommand::class);
        $this->addArtisan(ListCommand::class);
        $this->addArtisan(MakeModule::class);
        $this->addArtisan(ModuleEnableCommand::class);
        $this->addArtisan(ModuleDisableCommand::class);
        $this->addArtisan(MakeMigrationCommand::class);
        $this->addArtisan(MakeRouteCommand::class);
        $this->addArtisan(RouteListCommand::class);
        $this->addArtisan(TransDiff::class);
        $this->addArtisan(CheckMigrationCommand::class);
        $this->addArtisan(DocCommand::class);
    }



    /**
     * perform app init if necessary
     *
     * @return void
     */
    public static function initIfNecessary()
    {
        $value = session()->pull('yasna_init_first');
        if ($value == 1) {
            Artisan::call("yasna:init");
        } elseif ($value == 2) {
            Artisan::call("yasna:init");
        }
    }



    /**
     * safely seed into the database
     *
     * @param string $table_name
     * @param array  $data_array
     * @param bool   $truncate_first
     *
     * @return int
     */
    public static function seed($table_name, $data_array, $truncate_first = false)
    {
        return (new YasnaSeedingTool($table_name, $data_array))->run();
    }



    /**
     * safely find a model instance
     *
     * @param string $class_name
     * @param int    $needle
     * @param bool   $with_trashed
     *
     * @return Model
     */
    public static function model($class_name, $needle = 0, $with_trashed = false)
    {
        $class_name = studly_case($class_name);
        $class      = MODELS_NAMESPACE . $class_name;

        if (method_exists($class, 'grabber')) {
            return $class::grabber($needle, $with_trashed);
        } else {
            return self::_model($class_name, $needle, $with_trashed);
        }
    }



    /**
     * load model from the previous system
     *
     * @param string $class_name
     * @param int    $id
     * @param bool   $with_trashed
     *
     * @deprecated
     * @return Model
     */
    public static function _model($class_name, $id, $with_trashed = false)
    {
        /*-----------------------------------------------
        | Preparation ...
        */
        if (str_contains($class_name, '::')) {
            $class_name = str_after($class_name, '::');
        }
        $class_name = studly_case($class_name);
        $class      = MODELS_NAMESPACE . $class_name;
        /*-----------------------------------------------
       | Process ...
       */
        if (!$id) {
            return new $class();
        } elseif (is_numeric($id)) {
            if ($with_trashed) {
                return model($class_name)->withTrashed()->findOrNew($id);
            } else {
                return model($class_name)->findOrNew($id);
            }
        } elseif (is_string($id)) {
            return model($class_name, hashid($id, 'ids'), $with_trashed);
        } else {
            return model($class_name);
        }
    }



    /**
     * @param $id
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Model|null|User
     */
    public static function user($id)
    {
        /*-----------------------------------------------
        | If looking for a specific person ...
        */
        if ($id) {
            return model('User', $id);
        }

        /*-----------------------------------------------
        | Logged-In User ...
        */
        if (Auth::check()) {
            return Auth::user();
        }

        /*-----------------------------------------------
        | Otherwise ...
        */
        if (class_exists('App\Models\User')) {
            return model('user');
        }

        return new \Modules\Yasna\Entities\User();
    }



    /**
     * get an instance of the custom validation
     *
     * @return ValidationServiceProvider
     */
    public static function customValidation()
    {
        return ValidationServiceProvider::class;
    }



    /**
     * runs trans() module and returns the last key if not found
     *
     * @param string $key
     * @param array  $replace
     * @param string $locale
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|mixed|null|string
     */
    public static function transSafe($key = null, $replace = [], $locale = null)
    {
        if (Lang::has($key)) {
            return trans($key, $replace, $locale);
        } else {
            return array_last(explode('.', $key));
        }
    }



    /**
     * recursively find a trans in the given module and all her parents
     *
     * @param $map
     *
     * @return string|array
     */
    public static function transRecursive($map)
    {
        $module = module(str_before($map, "::"));
        $phrase = str_after($map, "::");

        if ($module->isNotValid()) {
            return trans($map);
        }

        if (trans()->has($map)) {
            return trans($map);
        }

        $parents = $module->getAllParentModules();
        $total   = count($parents);
        for ($i = $total - 1; $i >= 0; $i--) {
            $module      = strtolower($parents[$i]);
            $tried_map   = "$module::$phrase";
            $tried_trans = trans($tried_map);
            if ($tried_map != $tried_trans) {
                return $tried_trans;
            }
        }

        return $map;
    }



    /**
     * register middlewares of this module
     */
    public function registerMiddlewares()
    {
        $this->addMiddleware('is', IsMiddleware::class);
        $this->addMiddleware('can', CanMiddleware::class);
        $this->addMiddleware('sub-domain', SubDomainMiddleware::class);
    }



    /**
     * register all the schedules registered in the modules.
     *
     * @param Schedule $schedule
     */
    public static function schedule(Schedule $schedule)
    {
        foreach (module('yasna')->service('schedules')->read() as $item) {
            $class    = $item['class'];
            $instance = new $class($schedule);
            $instance->handle();
        }
    }



    /**
     * sets recaptcha config
     */
    protected function setReCaptchaConfigs()
    {
        if ($this->isNotInitialized()) {
            return;
        }
        config([
             'captcha.siteKey'   => getSetting('captcha_site_key'),
             "captcha.secretKey" => getSetting('captcha_secret_key'),
        ]);

        return;
    }



    /**
     * Bind proper path for public folder
     */
    protected function bindPublicPath()
    {
        $env_public         = env('PUBLIC_FOLDER');
        $public_folder_path = base_path($env_public);

        if ($env_public and File::exists($public_folder_path) and File::isDirectory($public_folder_path)) {
            $this->app->bind('path.public', function () use ($public_folder_path) {
                return $public_folder_path;
            });
        }
    }



    /**
     * Register Schedule
     */
    private function registerSchedules()
    {
        $this->addSchedule(RepositionFavIconSchedule::class);
    }



    /**
     * Set base url of the app.
     */
    protected function setAppUrlForConsole()
    {
        if ($this->module()->isNotInitialized()) {
            return;
        }

        if (!app()->runningInConsole()) {
            return;
        }

        $setting = getSetting('site_url');

        if ($setting and filter_var($setting, FILTER_VALIDATE_URL)) {
            config(['app.url' => $setting]);
            url()->forceRootUrl(config('app.url'));
        }
    }



    /**
     * Adds Yasna standard fields to all migrations, by a single command
     * Example: yasna()->additionalMigrations($table);
     *
     * @param Blueprint $table
     *
     * @return Blueprint
     */
    public function additionalMigrations(Blueprint $table)
    {
        $table->softDeletes();

        $table->unsignedInteger('created_by')->default(0)->index();
        $table->unsignedInteger('updated_by')->default(0)->index();
        $table->unsignedInteger('deleted_by')->default(0)->index();

        $table->longText('meta')->nullable();
        $table->tinyInteger('converted')->default(0)->index();
        $table->index('created_at');

        return $table;
    }
}
