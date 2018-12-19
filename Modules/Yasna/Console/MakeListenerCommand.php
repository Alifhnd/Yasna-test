<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeListenerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-listener';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a QueueEnabled listener.';

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
            $this->error('Pattern: yasna:make-listener [class_name] [module_name]. Both are required.');
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
        return $this->module->getPath('Listeners');
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
            fwrite($file, "namespace " . str_after($this->module->namespace('Listeners'), "\\") . ";");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, 'use Illuminate\Contracts\Queue\ShouldQueue;');
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "class $this->class_name implements ShouldQueue");
            fwrite($file, LINE_BREAK);
            fwrite($file, "{");
            fwrite($file, LINE_BREAK . TAB . 'public $tries = 5;');
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK . TAB . 'public function handle(FolanHappened $event)');
            fwrite($file, LINE_BREAK . TAB . '{');
            fwrite($file, LINE_BREAK . TAB . TAB .'//@TODO: Replace your event with the stupid hardcoded `FolanHappened`');
            fwrite($file, LINE_BREAK . TAB . '}');

            fwrite($file, LINE_BREAK);
            fwrite($file, "}");
            fwrite($file, LINE_BREAK . '//@TODO: Do not forget to register your listener in your module service provider.');
            fwrite($file, LINE_BREAK);


            fclose($file);

            $this->info("$path is created!");
        }
    }
}
