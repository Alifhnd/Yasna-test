<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DummyCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:dummy [module-name]';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs DummyTableSeeder of the selected modules, if any.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->argument('module-name')) {
            $done = $this->singleModule($this->argument('module-name'));
        } else {
            $done = $this->allModules();
        }

        if ($done) {
            $this->info("Total $done Seeders executed.");
        } else {
            $this->warn(" No DummyTableSeeder class found in the scope. ");
        }
    }

    public function allModules()
    {
        $done = 0;

        $this->line('Going through all the modules...');
        foreach (module()->list() as $module_name) {
            $done += $this->singleModule($module_name);
        }

        return $done;
    }

    public function singleModule($module_name)
    {
        $class = module($module_name)->namespace("Database\\Seeders\\DummyTableSeeder");
        $done  = 0;

        if (class_exists($class)) {
            $this->line("Running $module_name/.../DummyTableSeeder::run()");
            $seeder = new $class();
            $seeder->run();
            $this->line("Done.");
            $done++;
        }

        return $done;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module-name', InputArgument::OPTIONAL, 'The Module Name'],
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
}
