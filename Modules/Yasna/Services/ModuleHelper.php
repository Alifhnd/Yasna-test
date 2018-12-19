<?php
namespace Modules\Yasna\Services;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Modules\Yasna\Services\ModuleTraits\MagicTrait;
use Modules\Yasna\Services\ModuleTraits\ServicesTrait;
use Modules\Yasna\Services\ModuleTraits\StuffTrait;
use Nwidart\Modules\Facades\Module;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModuleHelper
{
    use ServicesTrait;
    use MagicTrait;
    use StuffTrait;

    public    $module;
    public    $name;
    public    $namespace;
    public    $provider;
    public    $title;
    protected $request_module;
    protected $static_mode;



    /**
     * ModuleHelper constructor.
     *
     * @param null $request_module
     */
    public function __construct($request_module = null)
    {
        $this->request_module = $request_module;
        $this->builder();
    }



    /**
     * Automatically called by module() helper.
     */
    protected function builder()
    {
        $this->static_mode = !boolval($this->request_module);
        if ($this->request_module) {
            $this->selector();
            if ($this->isValid()) {
                $this->name      = $this->getName();
                $this->namespace = $this->getLowerName();
                $this->provider  = $this->getProviderName();
                return;
            }
        }
    }



    /**
     * select the module, by its request name, trying singular and plural forms if failed.
     */
    protected function selector()
    {
        $this->module = Module::find($this->request_module);
        if ($this->isValid()) {
            return;
        }

        $plural_name  = str_plural($this->request_module);
        $this->module = Module::find($plural_name);
        if ($this->isValid()) {
            $this->request_module = $plural_name;
            return;
        }

        $singular_name = str_singular($this->request_module);
        $this->module  = Module::find($singular_name);
        if ($this->isValid()) {
            $this->request_module = $singular_name;
            return;
        }
    }



    /**
     * Returns true if in static mode. ie. module() helper has been called without argument.
     *
     * @return boolean
     */
    protected function static ()
    {
        return $this->static_mode;
    }



    /*
    |--------------------------------------------------------------------------
    | Main Information
    |--------------------------------------------------------------------------
    | These are the original module-methods, repeated here for the ease of access:
    | Complete list: https://nwidart.com/laravel-modules/v2/advanced-tools/module-methods
    */

    /**
     * @return bool
     */
    public function isValid()
    {
        return !$this->isNotValid();
    }



    /**
     * @return bool
     */
    public function isNotValid()
    {
        return empty($this->module);
    }



    /**
     * @return string
     */
    public function getName()
    {
        return $this->module->getName();
    }



    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->module->order;
    }



    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->module->isStatus(true);
    }



    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->module->get('alias');
    }



    /**
     * @return string
     */
    public function getLowerName()
    {
        return $this->module->getLowerName();
    }



    /**
     * @return string
     */
    public function getStudlyName()
    {
        return $this->module->getStudlyName();
    }



    /**
     * @param string $additive
     *
     * @return string
     */
    public function getPath($additive = null)
    {
        if (!$additive) {
            return $this->module->getPath();
        } else {
            return $this->module->getPath() . DIRECTORY_SEPARATOR . $additive;
        }
    }



    /**
     * @param string $folder_name
     *
     * @return string
     */
    public function getExtraPath($folder_name = 'Assets')
    {
        return $this->module->getExtraPath($folder_name);
    }



    /**
     * @return bool
     */
    public function enable()
    {
        if ($this->isNotValid()) {
            return false;
        }

        $active_modules = explode_not_empty('|', getSetting('active_modules'));
        if (!in_array($this->getName(), $active_modules)) {
            $active_modules[] = $this->getName();
            setting('active_modules')->setCustomValue(implode('|', $active_modules));
        }

        return true;
    }



    /**
     * @return bool
     */
    public function disable()
    {
        if ($this->isNotValid()) {
            return false;
        }

        $active_modules = explode_not_empty('|', getSetting('active_modules'));
        if (in_array($this->getName(), $active_modules)) {
            $active_modules = array_remove($active_modules, $this->getName());
            setting('active_modules')->setCustomValue(implode('|', $active_modules));
        }

        return true;
    }



    /*
    |--------------------------------------------------------------------------
    | Extra Information
    |--------------------------------------------------------------------------
    |
    */

    /**
     * The sole purpose of this method is to manipulate the grid-view in manage area.
     *
     * @param null $key
     *
     * @return Collection
     */
    public function collect($key = null)
    {
        if (!isset($key)) {
            $key = rand(100, 999); //<~~ Not Important at all :)
        }
        $item = new Collection();

        $item->id           = $key;
        $item->hashid       = $this->getName();
        $item->slug         = $this->getName();
        $item->title        = $this->getTitle();
        $item->version      = $this->module->version;
        $item->order        = $this->module->order;
        $item->release_date = $this->module->release_date;
        $item->active       = $this->module->active;
        $item->status       = $item->active ? "active" : "inactive";

        return $item;
    }



    /**
     * @param null $additives
     *
     * @return string
     */
    public function getNamespace($additives = null)
    {
        return "\\Modules\\" . $this->getStudlyName() . "\\" . studly_case($additives);
    }



    /**
     * @param null $additives
     *
     * @return string
     */
    public function namespace($additives = null)
    {
        return $this->getNamespace($additives);
    }



    /**
     * @param bool  $method_name
     * @param array ...$method_arguments
     *
     * @return string
     * @deprecated
     */
    public function provider($method_name = false, ... $method_arguments)
    {
        if ($method_name) {
            return $this->callProviderMethod($method_name, $method_arguments);
        } else {
            return $this->getProviderName();
        }
    }



    /**
     * @return string: Fully qualified ServiceProvider name.
     */
    public function getProviderName()
    {
        return $this->getNamespace('Providers\\' . $this->getStudlyName() . 'ServiceProvider');
    }



    /**
     * @return YasnaProvider: an instance of the module service provider.
     */
    public function getProvider()
    {
        $provider_name = $this->getProviderName();
        return new $provider_name(app());
    }



    /**
     * Calls a member/static method, within the module service provider.
     *
     * @param       $method_name
     * @param array ...$method_arguments
     *
     * @return mixed
     */
    public function callProviderMethod($method_name, ... $method_arguments)
    {
        return $this->getProvider()->$method_name(...$method_arguments);
    }



    /**
     * @param       $model_name
     * @param null  $method_name
     * @param array ...$method_arguments
     *
     * @return string
     * @deprecated
     */
    public function model($model_name, $method_name = null, ... $method_arguments)
    {
        $namespace = $this->getNamespace('Entities\\' . studly_case($model_name));
        if ($method_name) {
            return $namespace::$method_name(... $method_arguments);
        } else {
            return $namespace;
        }
    }



    /**
     * @param $model_name
     *
     * @return string : Fully qualified Model namespace.
     */
    public function getModelName($model_name)
    {
        return $this->getNamespace('Entities\\' . studly_case($model_name));
    }



    /**
     * @param null  $controller_name
     * @param null  $method_name
     * @param array ...$method_arguments
     *
     * @return string
     * @deprecated
     */
    public function controller($controller_name = null, $method_name = null, ... $method_arguments)
    {
        if (!$controller_name) {
            return $this->getControllersNamespace();
        } elseif (!$method_name) {
            return $this->getControllerName($controller_name);
        } else {
            return $this->callControllerMethod($controller_name, $method_name, ...$method_arguments);
        }
    }



    /**
     * get controller namespace
     *
     * @var string $additive
     * @return string: Namespace of the Controllers
     */
    public function getControllersNamespace($additive = null)
    {
        $namespace = "Http\\Controllers";
        if ($additive) {
            $namespace .= "\\" . $additive;
        }

        return $this->getNamespace($namespace);
    }



    /**
     * @param $model_name
     *
     * @return string : Fully qualified Controller name.
     */
    public function getControllerName($controller_name = null)
    {
        return $this->getControllersNamespace() . "\\" . studly_case($controller_name);
    }



    /**
     * @param $controller_name
     *
     * @return YasnaController
     */
    public function getController($controller_name)
    {
        $controller = $this->getControllerName($controller_name);
        return new $controller();
    }



    /**
     * Calls a member/static method, within the module requested controller.
     *
     * @param       $controller_name
     * @param       $method_name
     * @param array ...$arguments
     *
     * @return mixed
     */
    public function callControllerMethod($controller_name, $method_name, ... $method_arguments)
    {
        return $this->getController($controller_name)->$method_name(... $method_arguments);
    }



    /**
     * @param null  $view_address
     * @param array ...$arguments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($view_address = null, ...$arguments)
    {
        $view_name = $this->viewName($view_address);
        if (!view()->exists($view_name)) {
            if (config('app.debug')) {
                return ss("view file [$view_name] not found!");
            } else {
                return view('yasna::errors.m410');
            }
        }

        return view($view_name, ... $arguments);
    }



    /**
     * @param null $view_address
     *
     * @return string
     */
    public function viewName($view_address = null)
    {
        return snake_case($this->name) . '::' . $view_address;
    }



    /**
     * get a list of migration files
     *
     * @return array
     */
    public function migrations()
    {
        $path       = $this->getPath() . DIRECTORY_SEPARATOR . "Database" . DIRECTORY_SEPARATOR . "Migrations";
        $files      = scandir($path);
        $migrations = [];

        foreach ($files as $file) {
            if (str_contains($file, ".php")) {
                $migrations[] = str_before($file, '.php');
            }
        }

        return $migrations;
    }



    /**
     * @return array
     */
    public function models()
    {
        $path   = $this->getPath() . DIRECTORY_SEPARATOR . "Entities";
        $files  = scandir($path);
        $models = [];

        foreach ($files as $file) {
            if (str_contains($file, ".php")) {
                $models[] = str_before($file, '.');
            }
        }

        return $models;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        $title = $this->module->title;
        if (!$title) {
            $title = $this->getName();
        }

        return $title;
    }



    /**
     * @return array
     */
    public function getParentModules()
    {
        return $this->module->get('parent_modules');
    }



    /**
     * get all parent modules recursively
     *
     * @return array
     */
    public function getAllParentModules()
    {
        $parents  = (array) $this->getParentModules();
        $has_more = true;

        while ($has_more) {
            $has_more = false;

            foreach ($parents as $parent) {
                if (module($parent)->isNotValid()) {
                    continue;
                }

                $new_parents = module($parent)->getParentModules();
                if (is_array($new_parents)) {
                    foreach ($new_parents as $new_parent) {
                        if (!in_array($new_parent, $parents)) {
                            $has_more  = true;
                            $parents[] = $new_parent;
                        }
                    }
                }
            }
        }

        return $this->sortModulesList($parents);
    }



    /*
    |--------------------------------------------------------------------------
    | Static Mode
    |--------------------------------------------------------------------------
    |
    */

    /**
     * sort module list
     *
     * @param array $modules
     *
     * @return array
     */
    public function sortModulesList(array $modules): array
    {
        $all_modules = $this->list(true);
        $result      = [];

        foreach ($all_modules as $module) {
            if (in_array($module, $modules)) {
                $result[] = $module;
            }
        }

        return $result;
    }



    /**
     * @return mixed
     */
    public function enabled()
    {
        return Module::getOrdered();
    }



    /**
     * @return mixed
     */
    public function disabled()
    {
        return Module::disabled();
    }



    /**
     * @return array
     */
    public function all()
    {
        /*-----------------------------------------------
        | Make a sorted list ...
        */

        $modules = Module::all();
        uasort($modules, function (\Nwidart\Modules\Module $a, \Nwidart\Modules\Module $b) {
            if ($a->order == $b->order) {
                return 0;
            }

            return $a->order > $b->order ? 1 : -1;
        });

        /*-----------------------------------------------
        | Return ...
        */
        $result = [];
        foreach ($modules as $module) {
            $result[] = module($module->getName());
        }

        return $result;
    }



    /**
     * @param bool $with_disabled
     *
     * @return array
     */
    public function list($with_disabled = false)
    {
        $result = [];
        if ($with_disabled) {
            $modules = $this->all();
        } else {
            $modules = $this->enabled();
        }

        foreach ($modules as $module) {
            $result[] = $module->getName();
        }

        return $result;
    }



    /**
     * Checks if a certain module has been defined.
     *
     * @param $module_name
     * @param $with_disabled
     *
     * @return bool
     */
    public function isDefined($module_name)
    {
        return in_array(studly_case($module_name), $this->list(true));
    }



    /**
     * Checks if a certain module hasnot been defined.
     *
     * @param $module_name
     * @param $with_disabled
     *
     * @return bool
     */
    public function isNotDefined($module_name)
    {
        return !$this->isDefined($module_name);
    }



    /**
     * @param bool $with_disabled
     *
     * @return int
     */
    public function total($with_disabled = false)
    {
        if ($with_disabled) {
            return Module::count();
        } else {
            return count($this->list());
        }
    }



    /**
     * @param bool $with_disabled
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection($with_disabled = true)
    {
        $array = [];
        foreach ($this->list($with_disabled) as $key => $slug) {
            $array[] = module($slug)->collect($key);
        }

        return collect($array);
    }



    /**
     * @param bool $neglect_cache
     *
     * @return bool|\Illuminate\Contracts\Cache\Repository
     */
    public function isInitialized($neglect_cache = false)
    {
        $cache_slug   = 'yasna-initialized';
        $vital_models = ['User', 'Setting'];
        $path         = app_path('Models');

        /*-----------------------------------------------
        | Use Cache ...
        */
        if (config('app.debug') or app()->runningInConsole()) {
            $neglect_cache = true;
        }
        if (!$neglect_cache and cache()->has($cache_slug)) {
            return cache()->get($cache_slug);
        }

        /*-----------------------------------------------
        | Neglect Cache ...
        */
        cache()->forget($cache_slug);

        if (!is_dir($path)) {
            return false;
        }

        foreach ($vital_models as $model) {
            if (!file_exists("$path/$model.php")) {
                return false;
            }
        }

        cache()->add($cache_slug, true, 10);
        return true;
    }



    /**
     * @param bool $neglect_cache
     *
     * @return bool
     */
    public function isNotInitialized($neglect_cache = false)
    {
        return !$this->isInitialized($neglect_cache);
    }
}
