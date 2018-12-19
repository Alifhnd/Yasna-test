<?php
/**
 * Created by PhpStorm.
 * User: davodsaraei
 * Date: 6/24/2018
 * Time: 3:05 PM
 */

namespace Modules\Yasna\Classes;

use Carbon\Carbon;
use Nwidart\Modules\Generators\Generator;
use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command as Console;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Nwidart\Modules\Repository;
use Nwidart\Modules\Support\Stub;

class YasnaModuleGenerator extends Generator
{
    /**
     * The module name will created.
     *
     * @var string
     */
    protected $name;

    /**
     * The laravel config instance.
     *
     * @var Config
     */
    protected $config;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * The laravel console instance.
     *
     * @var Console
     */
    protected $console;

    /**
     * The ping-pong module instance.
     *
     * @var $module
     */
    protected $module;

    /**
     * Force status.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Generate a plain module.
     *
     * @var bool
     */
    protected $plain = false;
    private $release_date;
    private $order;
    private $description;
    private $title;
    private $version;
    private $author_email;
    private $author_name;
    private $parent_modules;



    /**
     * The constructor.
     *
     * @param            $name
     * @param Repository $module
     * @param Config     $config
     * @param Filesystem $filesystem
     * @param Console    $console
     */
    public function __construct(
         $name,
         Repository $module = null,
         Config $config = null,
         Filesystem $filesystem = null,
         Console $console = null
    ) {
        $this->name       = $name;
        $this->config     = $config;
        $this->filesystem = $filesystem;
        $this->console    = $console;
        $this->module     = $module;
    }



    /**
     * Set plain flag.
     *
     * @param bool $plain
     *
     * @return $this
     */
    public function setPlain($plain)
    {
        $this->plain = $plain;

        return $this;
    }



    /**
     * Get the name of module will created. By default in studly case.
     *
     * @return string
     */
    public function getName()
    {
        return Str::studly($this->name);
    }



    /**
     * Get the laravel config instance.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }



    /**
     * Set the laravel config instance.
     *
     * @param Config $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }



    /**
     * Get the laravel filesystem instance.
     *
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }



    /**
     * Set the laravel filesystem instance.
     *
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }



    /**
     * Get the laravel console instance.
     *
     * @return Console
     */
    public function getConsole()
    {
        return $this->console;
    }



    /**
     * Set the laravel console instance.
     *
     * @param Console $console
     *
     * @return $this
     */
    public function setConsole($console)
    {
        $this->console = $console;

        return $this;
    }



    /**
     * Get the ping-pong module instance.
     *
     * @return Module
     */
    public function getModule()
    {
        return $this->module;
    }



    /**
     * Set the pingpong module instance.
     *
     * @param mixed $module
     *
     * @return $this
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }



    /**
     * Get the list of folders will created.
     *
     * @return array
     */
    public function getFolders()
    {
        return array_values(config('modules.paths.generator'));
    }



    /**
     * Get the list of files will created.
     *
     * @return array
     */
    public function getFiles()
    {
        return [
             'start'           => 'start.php',
             'routes'          => 'Http/routes.php',
             //'views/index'     => 'Resources/views/index.blade.php',
             //'views/master'    => 'Resources/views/layouts/plane.blade.php',
             'scaffold/config' => 'Config/config.php',
             'composer'        => 'composer.json',
        ];

        //        return config('modules.stubs.files');
    }



    /**
     * Set force status.
     *
     * @param bool|int $force
     *
     * @return $this
     */
    public function setForce($force)
    {
        $this->force = $force;

        return $this;
    }



    /**
     * Generate the module.
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function generate()
    {
        $name = $this->getName();

        if ($this->module->has($name)) {
            if ($this->force) {
                $this->module->delete($name);
            } else {
                $this->console->error("Module [{$name}] already exist!");

                return;
            }
        }

        $this->generateFolders();
        $this->generateModuleJsonFile();
        $this->generateResources();
        $this->generateFiles();

        //if ($this->plain === true) {
        //    $this->cleanModuleJsonFile();
        //}

        $this->console->info("Module [{$name}] created successfully.");
    }



    /**
     * Generate the folders.
     */
    public function generateFolders()
    {
        foreach ($this->getFolders() as $folder) {
            $path = $this->module->getModulePath($this->getName()) . '/' . $folder;

            $this->filesystem->makeDirectory($path, 0755, true);

            $this->generateGitKeep($path);
        }
    }



    /**
     * Generate git keep to the specified path.
     *
     * @param string $path
     */
    public function generateGitKeep($path)
    {
        $this->filesystem->put($path . '/.gitkeep', '');
    }



    /**
     * Generate the files.
     */
    public function generateFiles()
    {
        foreach ($this->getFiles() as $stub => $file) {
            $path = $this->module->getModulePath($this->getName()) . $file;

            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            $this->filesystem->put($path, $this->getStubContents($stub));

            $this->console->info("Created : {$path}");
        }
    }



    /**
     * Generate some resources.
     */
    public function generateResources()
    {
        $this->console->call('module:make-seed', [
             'name'     => $this->getName(),
             'module'   => $this->getName(),
             '--master' => true,
        ]);

        $this->console->call('module:make-provider', [
             'name'     => $this->getName() . 'ServiceProvider',
             'module'   => $this->getName(),
             '--master' => true,
        ]);

        //$this->console->call('module:make-controller', [
        //     'controller' => $this->getName() . 'Controller',
        //     'module'     => $this->getName(),
        //]);
    }



    /**
     * Get the contents of the specified stub file by given stub name.
     *
     * @param $stub
     *
     * @return string
     */
    protected function getStubContents($stub)
    {
        Stub::setBasePath(dirname(__FILE__) . "/../Console/stubs/");

        return (new Stub($stub . '.stub',
             $this->getReplacement($stub)
        )
        )->render();
    }



    /**
     * get the list for the replacements.
     */
    public function getReplacements()
    {
        return config('modules.stubs.replacements');
    }



    /**
     * Get array replacement for the specified stub.
     *
     * @param $stub
     *
     * @return array
     */
    protected function getReplacement($stub)
    {
        $replacements = config('yasna.modules.stubs.replacements');

        if (!isset($replacements[$stub])) {
            return [];
        }

        $keys = $replacements[$stub];

        $replaces = [];

        foreach ($keys as $key) {
            if (method_exists($this, $method = 'get' . ucfirst(studly_case(strtolower($key))) . 'Replacement')) {
                $replaces[$key] = call_user_func([$this, $method]);
            } else {
                $replaces[$key] = null;
            }
        }

        return $replaces;
    }



    /**
     * Generate the module.json file
     */
    private function generateModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()) . 'module.json';

        if (!$this->filesystem->isDirectory($dir = dirname($path))) {
            $this->filesystem->makeDirectory($dir, 0775, true);
        }

        $this->filesystem->put($path, $this->getStubContents('json'));

        $this->console->info("Created : {$path}");
    }



    /**
     * Remove the default service provider that was added in the module.json file
     * This is needed when a --plain module was created
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    private function cleanModuleJsonFile()
    {
        $path = $this->module->getModulePath($this->getName()) . 'module.json';

        $content    = $this->filesystem->get($path);
        $namespace  = $this->getModuleNamespaceReplacement();
        $studlyName = $this->getStudlyNameReplacement();

        $provider = '"' . $namespace . '\\\\' . $studlyName . '\\\\Providers\\\\' . $studlyName . 'ServiceProvider"';

        $content = str_replace($provider, '', $content);

        $this->filesystem->put($path, $content);
    }



    /**
     * Get the module name in lower case.
     *
     * @return string
     */
    protected function getLowerNameReplacement()
    {
        return strtolower($this->getName());
    }



    /**
     * Get the module name in studly case.
     *
     * @return string
     */
    protected function getStudlyNameReplacement()
    {
        return $this->getName();
    }



    /**
     * Get replacement for $VENDOR$.
     *
     * @return string
     */
    protected function getVendorReplacement()
    {
        return config('modules.composer.vendor');
    }



    /**
     * Get replacement for $MODULE_NAMESPACE$.
     *
     * @return string
     */
    protected function getModuleNamespaceReplacement()
    {
        return str_replace('\\', '\\\\', config('modules.namespace'));
    }



    /**
     * Get replacement for $AUTHOR_NAME$.
     *
     * @return string
     */
    protected function getAuthorNameReplacement()
    {
        return $this->author_name;
    }



    /**
     * @param $author_name
     *
     * @return $this
     */
    public function setAuthorName($author_name)
    {
        $this->author_name = $author_name;

        return $this;
    }



    /**
     * @param $author_mail
     *
     * @return $this
     */
    public function setAuthorEmail($author_mail)
    {
        $this->author_email = $author_mail;

        return $this;
    }



    /**
     * Get replacement for $AUTHOR_EMAIL$.
     *
     * @return string
     */
    protected function getAuthorEmailReplacement()
    {
        return $this->author_email;
    }



    /**
     * @param $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }



    /**
     * @param $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }



    /**
     * @param $order
     *
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }



    /**
     * @param $version
     *
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }



    /**
     * @param $release_date
     *
     * @return $this
     */
    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;

        return $this;
    }



    /**
     * @return string
     */
    protected function getTitleReplacement()
    {
        return $this->title;
    }



    /**
     * @return string
     */
    protected function getDescriptionReplacement()
    {
        return $this->description;
    }



    /**
     * @return string
     */
    protected function getOrderReplacement()
    {
        return $this->order;
    }



    /**
     * @return string
     */
    protected function getVersionReplacement()
    {
        return $this->version;
    }



    /**
     * @return string
     */
    protected function getReleaseDateReplacement()
    {
        return $this->release_date;
    }



    /**
     * @return string
     */
    protected function getParentModulesReplacement()
    {
        return $this->parent_modules;
    }



    /**
     * @param $parent_modules
     *
     * @return $this
     */
    public function setParentModules($parent_modules)
    {
        $to_str = null;
        $count  = count($parent_modules);
        foreach ($parent_modules as $key => $parent_module) {
            $to_str .= '"' . studly_case(trim($parent_module)) . '"';
            if ($key < $count - 1) {
                $to_str .= ',';
            }
        }

        $this->parent_modules = $to_str;

        return $this;
    }
}
