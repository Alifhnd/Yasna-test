<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;

class ListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:list';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all modules.';
    private $row_header_array;



    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $headers = $this->generateHeaderArray();
        $body    = $this->generateBodyArray();

        $this->table($headers, $body, 'compact');
    }



    /**
     * @return array
     */
    private function generateHeaderArray()
    {
        return [
             '#',
             'Module',
             'Order',
             'Status',
        ];
    }



    /**
     * @return array
     */
    private function generateBodyArray()
    {
        $array   = [];
        $modules = module()->list($this->option('all'));
        $spacer  = ' ';

        foreach ($modules as $i => $module) {
            $module  = module($module);
            $array[] = [
                 strval($i + 1) . $spacer,
                 $module->getName() . $spacer,
                 $module->getOrder() . $spacer . $spacer,
                 $module->getStatus() ? "Active" : ".",
            ];
        }

        return $array;
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
            ['all', 'a', InputOption::VALUE_NONE, 'Flag to force show all modules', null],
        ];
    }
}
