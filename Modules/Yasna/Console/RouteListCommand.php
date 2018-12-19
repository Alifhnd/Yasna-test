<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RouteListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists the partial routes of a particular module';

    protected $module = false;
    protected $module_name;



    /**
     * purifies the user request
     */
    protected function purifier()
    {
        $this->module_name = $this->argument('module_name');
        $this->module_name = studly_case($this->module_name);
        $this->module      = module($this->module_name);

        if (!$this->module_name) {
            $this->error('Pattern: yasna:routes [module_name].');
            die();
        }
        if ($this->module->isNotValid()) {
            $this->error("Module $this->module_name not found.");
            die();
        }

        $this->module_name = camel_case($this->module->getName());
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->purifier();
        $this->showFiles();
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
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
     * shows a list of route files
     *
     * @return void
     */
    protected function showFiles()
    {
        $directory = $this->folderPath();
        $files     = scandir($directory);
        $total     = 0;

        foreach ($files as $file) {
            if (str_contains($file, ".php")) {
                $total++;
                $this->info(str_before($file, '.php'));
            }
        }

        if(!$total) {
            $this->warn("Found 0 route files.");
        }
    }
}
