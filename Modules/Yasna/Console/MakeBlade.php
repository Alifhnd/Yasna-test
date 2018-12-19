<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\View;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeBlade extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name    = 'yasna:make-blade {full_blade_address}';
    protected $module  = false;
    protected $address = null;
    protected $folders_array;
    protected $blade_name;
    protected $base_folder;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes an empty blade file, with the fully qualified name.';



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



    public function parseAddress()
    {
        $this->module            = studly_case(str_before($this->address, "::"));
        $folder_and_blade_string = str_after($this->address, "::");
        $folder_and_blade_array  = explode('.', $folder_and_blade_string);
        $this->blade_name        = array_last($folder_and_blade_array);
        $this->folders_array     = array_remove($folder_and_blade_array, $this->blade_name);
        $this->base_folder       = module($this->module)->getPath("Resources" . DIRECTORY_SEPARATOR . "views");
    }



    public function validation()
    {
        if (!str_contains($this->address, '::')) {
            $this->error("Invalid Address Format. Use Module::folder.blade pattern.");
            return false;
        }

        if (View::exists($this->address)) {
            $this->error("The blade already exists!");
            return false;
        }

        if (module()->isNotDefined($this->module)) {
            $this->error("Module '$this->module' is not defined.");
            return false;
        }

        return true;
    }



    public function receiveAddress()
    {
        $this->address = $this->argument('blade-address');
    }



    protected function makeFolders()
    {
        foreach ($this->folders_array as $folder) {
            $this->base_folder .= DIRECTORY_SEPARATOR . $folder;
            $this->makeFolder();
        }
    }



    protected function makeFolder()
    {
        $path = $this->base_folder;

        if (!is_dir($path)) {
            mkdir($path);
        }
    }



    protected function makeFile()
    {
        $path = $this->base_folder . DIRECTORY_SEPARATOR . $this->blade_name . ".blade.php";

        if (file_exists($path)) {
            $this->warn("Blade file already exists. I did nothing!");
            return;
        }


        $file = fopen($path, 'w', true);
        fwrite($file, ":)");
        fclose($file);

        $this->successFeedback();
    }



    protected function successFeedback()
    {
        $divider = "Modules" . DIRECTORY_SEPARATOR;
        $path    = "..." . DIRECTORY_SEPARATOR . $divider . str_after($this->base_folder, $divider);
        $path .= DIRECTORY_SEPARATOR . $this->blade_name . ".blade.php";

        $this->info("New blade is created at $path.");
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*-----------------------------------------------
        | Preparations ...
        */
        $this->receiveAddress();
        $this->parseAddress();
        if (!$this->validation()) {
            return;
        }

        /*-----------------------------------------------
        | Actions ...
        */
        $this->makeFolders();
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
             ['blade-address', InputArgument::REQUIRED, 'Fully-Qualified Blade File Address'],
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
