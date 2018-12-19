<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Migrations\Migrator;

class CheckMigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:check-migrations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show list of non-executed migrations of enable modules';



    /**
     * return false if there is some migrations to execute
     *
     * @return bool
     */
    public static  function verify()
    {
        $obj        = new CheckMigrationCommand();
        $migrations = $obj->findMigrations();
        $result     = $obj->findNonExecutedMigrations($migrations);
        if (empty($result)) {
            return true;
        } else {
            return false;
        }
    }



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
     */
    public function handle()
    {
        $migrations = $this->findMigrations();
        $result     = $this->findNonExecutedMigrations($migrations);
        $this->showResult($result);
    }



    /**
     * show result of command
     *
     * @param array $result
     */
    private function showResult($result)
    {
        if (empty($result)) {
            $this->info("All Migrations Ran :)");
            return;
        }

        $this->error("Detected Not-Executed Migrations:");

        foreach ($result as $module => $migrations) {
            $this->warn("In `$module` Module:");
            foreach ($migrations as $migration) {
                $this->line($migration);
            }
        }
    }



    /**
     * get migrations of enable modules
     *
     * @return array
     */
    private function findMigrations()
    {
        $modules    = module()->list();
        $migrations = [];


        foreach ($modules as $module) {
            $founded_module      = module($module)->module;
            $path                = (new Migrator($founded_module))->getPath();
            $migrations[$module] = $this->getMigrationsFiles($path);
        }

        return $migrations;
    }



    /**
     * return none-executed migrations
     *
     * @param array $migrations
     *
     * @return array
     */
    private function findNonExecutedMigrations($migrations)
    {
        $nones_migrations = [];
        foreach ($migrations as $module => $migration) {
            foreach ($migration as $item) {
                $ran = DB::table('migrations')
                         ->where('migration', $item)
                         ->exists()
                ;
                if (!$ran) {
                    $nones_migrations[$module][] = $item;
                }
            }
        }
        return $nones_migrations;
    }



    /**
     * get migrations from a path
     *
     * @param string $path
     *
     * @return array
     */
    private function getMigrationsFiles($path)
    {
        return array_map(function ($item) {
            $file_name = substr($item, strrpos($item, "/") + 1);
            return substr($file_name, 0, strlen($file_name) - 4);
        }, glob($path . "/*.php"));
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
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
