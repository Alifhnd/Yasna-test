<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeControllerCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes an empty Controller file, extending YasnaController class.';

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

        if ($this->class_name and !str_contains($this->class_name, 'Controller')) {
            $this->class_name .= "Controller";
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
            $this->error('Pattern: yasna:make-controller [class_name] [module_name]. Both are required.');
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
        return $this->module->getPath('Http' . DIRECTORY_SEPARATOR . 'Controllers');
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
            fwrite($file, "namespace " . str_after($this->module->namespace('Http\Controllers'), "\\") . ";");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, 'use Modules\Yasna\Services\YasnaController;');
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "class $this->class_name extends YasnaController");
            fwrite($file, LINE_BREAK);
            fwrite($file, "{");
            fwrite($file, LINE_BREAK . TAB . 'protected $base_model  = ""; // @TODO <~~');
            fwrite($file, LINE_BREAK . TAB . 'protected $view_folder = ""; // @TODO <~~ (Remove if same as parent)');
            //fwrite($file, LINE_BREAK . TAB . '//Feel free to define purifier(), rules(), authorize() and messages() methods, as appropriate. ');

            fwrite($file, LINE_BREAK);
            fwrite($file, "}");
            fwrite($file, LINE_BREAK);

            fclose($file);

            $this->info("$path is created!");
        }
    }
}
