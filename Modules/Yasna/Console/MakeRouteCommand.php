<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeRouteCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a partial route file';

    protected $module = false;
    protected $module_name;
    protected $file_name;



    /**
     * purifies the user request
     */
    protected function purifier()
    {
        $this->file_name   = $this->argument('file_name');
        $this->module_name = $this->argument('module_name');
        $this->file_name   = snake_case($this->file_name);
        $this->module      = module($this->module_name);

        if (!$this->file_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-route [file_name] [module_name]. Both are required.');
            die();
        }
        if ($this->module->isNotValid()) {
            $this->error("Module $this->module_name not found.");
            die();
        }

        $this->module_name = $this->module->getName();
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->purifier();
        $this->makeFolder();
        $this->makeFile();
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
             ['file_name', InputArgument::OPTIONAL, 'Route File Name'],
             ['module_name', InputArgument::OPTIONAL, 'Module Name'],
        ];
    }



    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }



    /**
     * get folder path
     *
     * @return string
     */
    protected function folderPath()
    {
        return $this->module->getPath('Http' . DIRECTORY_SEPARATOR . 'Routes');
    }



    /**
     * make folder
     */
    public function makeFolder()
    {
        $path = $this->folderPath();
        if (!is_dir($path)) {
            mkdir($path);
            $this->line("Made folder...");
        }
    }



    /**
     * make file
     */
    public function makeFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->file_name . '.php';
        if (file_exists($path)) {
            $this->warn("File already exists!");
        } else {
            $file = fopen($path, 'w', true);
            fwrite($file, "<?php" . LINE_BREAK);
            fwrite($file, LINE_BREAK);

            fwrite($file, "Route::group([" . LINE_BREAK);

            fwrite($file, TAB . "'middleware' => 'web', " . LINE_BREAK);
            fwrite($file,
                 TAB . "'namespace'  => module('$this->module_name')->getControllersNamespace(), " . LINE_BREAK);
            fwrite($file, TAB . "'prefix'     => '$this->module_name' " . LINE_BREAK);

            fwrite($file, "], function () {" . LINE_BREAK);
            fwrite($file, TAB . "// Your routes comes here." . LINE_BREAK);

            fwrite($file, "});" . LINE_BREAK);

            fclose($file);

            $this->info("$path is created!");
        }
    }
}
