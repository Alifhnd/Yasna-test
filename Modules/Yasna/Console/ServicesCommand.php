<?php

namespace Modules\Yasna\Console;

use Hamcrest\Core\Set;
use Illuminate\Console\Command;
use Modules\Yasna\Entities\Setting;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ServicesCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:services';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of all registered Yasna services.';

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
        $module_name = $this->argument('module-name');

        $this->line('');
        if ($module_name) {
            $this->showRegistered($module_name, module($module_name)->registered());
        } else {
            foreach (module()->list() as $module_name) {
                $this->showRegistered($module_name, module($module_name)->registered());
            }
        }
        $this->showUnregistered($module_name);
    }

    protected function showRegistered($module, $list)
    {
        if (!count($list)) {
            return;
        }
        $this->warn("Module $module...");
        $rows = [];

        foreach ($list as $item) {
            $rows[] = [$item['service_name']  . " (".$item['usages'] . ")"  , "\t".$item['comment']];
        }

        $this->table([], $rows, 'compact');
        $this->line('');
    }

    protected function showUnregistered($module_name)
    {
        $list = module()->unregistered() ;
        if (count($list)) {
            $this->error("Unregistered Service(s) in module '$module_name': " . implode(', ', $list)) ;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module-name', InputArgument::OPTIONAL, 'Module Name'],
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
            //['counter', 'c', InputOption::VALUE_NONE, 'Shows the counter.', null],
        ];
    }
}
