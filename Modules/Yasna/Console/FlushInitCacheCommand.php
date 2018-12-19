<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;

class FlushInitCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:flush-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flushes init cache';



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
        cache()->forget("yasna-initialized");
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['example', InputArgument::REQUIRED, 'An example argument.'],
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
