<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeScheduleCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a Schedule class, extended from YasnaSchedule.';

    protected $module = false;
    protected $module_name;
    protected $class_name;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function purifier()
    {
        $this->class_name  = $this->argument('class_name');
        $this->module_name = $this->argument('module_name');

        $this->class_name  = studly_case($this->class_name);
        $this->module_name = studly_case($this->module_name);

        if ($this->class_name and !str_contains($this->class_name, 'Schedule')) {
            $this->class_name .= "Schedule";
        }

        $this->module = module($this->module_name);
    }


    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->purifier();

        /*-----------------------------------------------
        | Validation ...
        */
        if (!$this->class_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-schedule [class_name] [module_name]. Both are required.');
            return;
        }

        /*-----------------------------------------------
        | Run ...
        */
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
            ['class_name', InputArgument::OPTIONAL, 'Request Class Name'],
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

    protected function folderPath()
    {
        return $this->module->getPath(DIRECTORY_SEPARATOR . 'Schedules');
    }


    public function makeFolder()
    {
        $path = $this->folderPath();
        if (!is_dir($path)) {
            mkdir($path);
            $this->line("Made folder...");
        }
    }

    public function makeFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->class_name . '.php';
        if (file_exists($path)) {
            $this->warn("File already exists!");
        } else {
            $file = fopen($path, 'w', true);
            fwrite($file, "<?php ");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "namespace " . str_after($this->module->namespace('Schedules'), "\\") . ";");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, 'use Modules\Yasna\Services\YasnaSchedule;');
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "class $this->class_name extends YasnaSchedule");
            fwrite($file, LINE_BREAK);
            fwrite($file, "{");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . '//Feel free to incorporate additional() and condition() methods, or even override handle() method as appropriates.');
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . "//@TODO: Register this class, in your module service provider, using ->addSchedule(Folan::class) method, then remove this TODO line.");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);

            fwrite($file, TAB . "protected function job()");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . "{");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . TAB . "//Write the scheduled code here.");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . "}");

            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);

            fwrite($file, TAB . "protected function frequency()");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . "{");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . TAB . "return 'dailyAt:2:00'; //<~~ Default is 'dailyAt:2:00'. Remove the method, if you'd like to keep that.");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB . "}");

            fwrite($file, LINE_BREAK);
            fwrite($file, "}");
            fwrite($file, LINE_BREAK);

            fclose($file);

            $this->info("$path is created!");
        }
    }
}
