<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Reseed extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:reseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates all data and seeds everything again.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->line("Truncating Data...") ;
        Artisan::call("yasna:truncate") ;

        $this->line("Seeding Data...") ;
        Artisan::call("module:seed") ;

        $this->info("Done! :)") ;
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
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
