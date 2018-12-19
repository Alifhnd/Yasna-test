<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes an empty Model file, extending YasnaModel class.';

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



    /**
     * purify user inputs
     */
    protected function purifyUserInputs()
    {
        $this->class_name  = $this->argument('class_name');
        $this->module_name = $this->argument('module_name');

        $this->class_name  = studly_case($this->class_name);
        $this->module_name = studly_case($this->module_name);
        $this->module      = module($this->module_name);
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->purifyUserInputs();

        /*-----------------------------------------------
        | Validation ...
        */
        if (!$this->class_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-model [class_name] [module_name]. Both are required.');
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



    /**
     * get the required folder path
     *
     * @return string
     */
    protected function folderPath()
    {
        return $this->module->getPath('Entities');
    }



    /**
     * make the required folder
     */
    public function makeFolder()
    {
        $path = $this->folderPath();
        if (!is_dir($path)) {
            mkdir($path);
            $this->line("Made folder...");
        }
    }



    /**
     * make the required file
     */
    public function makeFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->class_name . '.php';
        if (file_exists($path)) {
            $this->warn("File already exists!");
            return;
        }

        $meta_note = '//TODO: Fill this with the names of your meta fields, or remove the method if you do not want meta fields at all.';

        $file = fopen($path, 'w', true);
        fwrite($file, "<?php ");
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, "namespace " . str_after($this->module->namespace('Entities'), "\\") . ";");
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, 'use Modules\Yasna\Services\YasnaModel;' . LINE_BREAK);
        fwrite($file, 'use Illuminate\Database\Eloquent\SoftDeletes;' . LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, "class $this->class_name extends YasnaModel");
        fwrite($file, LINE_BREAK);
        fwrite($file, "{" . LINE_BREAK);
        fwrite($file, TAB . 'use SoftDeletes;' . LINE_BREAK);

        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);

        fwrite($file, TAB . "/**" . LINE_BREAK);
        fwrite($file, TAB . SPACE . "* get the main meta fields of the table." . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*" . LINE_BREAK);
        fwrite($file, TAB . SPACE . '* @return array' . LINE_BREAK);
        fwrite($file, TAB . SPACE . "*/" . LINE_BREAK);
        fwrite($file, TAB . 'public function mainMetaFields()' . LINE_BREAK);
        fwrite($file, TAB . '{' . LINE_BREAK);
        fwrite($file, TAB . TAB . 'return [' . LINE_BREAK);
        fwrite($file, TAB . TAB . TAB . $meta_note . LINE_BREAK);
        fwrite($file, TAB . TAB . '];' . LINE_BREAK);
        fwrite($file, TAB . '}' . LINE_BREAK);

        fwrite($file, "}");
        fwrite($file, LINE_BREAK);

        fclose($file);

        $this->info("$path is created!");
    }
}
