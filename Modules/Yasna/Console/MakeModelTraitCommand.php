<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Commands\GeneratorCommand;
use Nwidart\Modules\Support\Stub;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeModelTraitCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-trait';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a Model Trait, in the specified module.';

    protected $module = false;
    protected $module_name;
    protected $trait_name;



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
     * purify the class and module names, supplied from the command line.
     */
    protected function purifier()
    {
        $this->trait_name  = $this->argument('trait_name');
        $this->module_name = $this->argument('module_name');

        $this->trait_name  = studly_case($this->trait_name);
        $this->module_name = studly_case($this->module_name);

        if ($this->trait_name and !str_contains($this->trait_name, 'Trait')) {
            $this->trait_name .= "Trait";
        }

        $this->module = module($this->module_name);
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->purifier();

        /*-----------------------------------------------
        | Validation ...
        */
        if (!$this->trait_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-trait [trait_name] [module_name]. Both are required.');
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
             ['trait_name', InputArgument::OPTIONAL, 'Request Trait Name'],
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
        return $this->module->getPath('Entities' . DIRECTORY_SEPARATOR . 'Traits');
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
     * make file
     */
    public function makeFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->trait_name . '.php';
        if (file_exists($path)) {
            $this->warn("File already exists!");
        } else {
            $file = fopen($path, 'w', true);

            fwrite($file, "<?php ");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "namespace " . str_after($this->module->namespace('Entities\Traits'), "\\") . ";");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "trait $this->trait_name" . LINE_BREAK);
            fwrite($file, "{" . LINE_BREAK);
            fwrite($file, "}" . LINE_BREAK);
            fwrite($file, "//@TODO: Do not forget to register it in your module service provider: ");
            fwrite($file, '$this->addModelTrait("' . $this->trait_name . '", "MODEL_NAME")');
            fwrite($file, "}" . LINE_BREAK);

            fclose($file);
            $this->info("$path is created!");
        }
    }
}
