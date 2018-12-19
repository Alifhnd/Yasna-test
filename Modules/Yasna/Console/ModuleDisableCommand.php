<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ModuleDisableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disables module(s) by their names';



    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $modules = $this->getModulesArray();
        $count   = 0;

        foreach ($modules as $module) {
            $count += module($module)->disable();
        }

        if (!$count) {
            $this->error("No modules got disabled!");
            return;
        }

        $this->info("$count modules got disabled.");
    }



    /**
     * Gets an array of module names provided by user.
     *
     * @return array
     */
    private function getModulesArray()
    {
        return explode_not_empty(',', $this->argument('modules'));
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
             ['modules', InputArgument::REQUIRED, "A list of comma-separated modules to be disabled."],
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
            //['database', 'd', InputOption::VALUE_NONE, 'Flag to make database follow the [module.json]s', null],
        ];
    }
}
