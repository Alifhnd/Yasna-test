<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Truncate extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncates all data from database tables.';

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

        /*-----------------------------------------------
        | Preparations ...
        */

        $tables   = DB::select('SHOW TABLES');
        $db_name  = env('DB_DATABASE');
        $variable = "Tables_in_$db_name";


        /*-----------------------------------------------
        | Process ...
        */
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        foreach ($tables as $table) {
            $table_name = $table->$variable;
            if ($table_name != 'migrations') {
                DB::table($table_name)->truncate();
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*-----------------------------------------------
        | Feedback ...
        */
        $this->info('Truncated all data.');
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
