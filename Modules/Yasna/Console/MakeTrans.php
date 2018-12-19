<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeTrans extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-trans {file}';
    protected $module = false ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a translation file in the module trans folder.';

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
     *
     * @return mixed
     */
    public function handle()
    {

        /*-----------------------------------------------
        | Check Module ...
        */
        $this->module = Module::find($this->argument('module-name')) ;
        if (!$this->argument('module-name')) {
            $this->error("Module name is not provided.") ;
            return ;
        }
        if (!$this->module) {
            $this->error("Module " . $this->argument('module-name') . ' not found!') ;
            return ;
        }
        if ($this->module->disabled()) {
            $this->warn("Module " . $this->argument('module-name') . ' is not active, but we continue anyway. ') ;
        }

        /*-----------------------------------------------
        | Action ...
        */

        if ($this->option('fa') === true or ($this->option('fa') !== true and $this->option('en') !== true and $this->option('ar') !== true)) {
            $this->makeFolder('fa') ;
            $this->makeFile('fa') ;
        }
        if ($this->option('en') === true) {
            $this->makeFolder('en') ;
            $this->makeFile('en') ;
        }
        if ($this->option('ar') === true) {
            $this->makeFolder('ar') ;
            $this->makeFile('ar') ;
        }

        return;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['file-name', InputArgument::REQUIRED, 'The Translation File Name'],
            ['module-name', InputArgument::OPTIONAL, 'The Module Name'],
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
            ['fa', null, InputOption::VALUE_NONE, 'Flag to make for Persian', null],
            ['en', null, InputOption::VALUE_NONE, 'Flag to make for English', null],
            ['ar', null, InputOption::VALUE_NONE, 'Flag to make for Arabic', null],
        ];
    }


    protected function makeFolder($lang)
    {
        $path = $this->getParentFolder() . DIRECTORY_SEPARATOR . strtolower($lang) ;
        if (is_dir($path)) {
            $this->info("Folder `$lang` already exists...") ;
        } else {
            mkdir($path) ;
            $this->info("Made folder `$lang`...") ;
        }
    }

    protected function makeFile($lang)
    {
        $path = $this->getParentFolder() . DIRECTORY_SEPARATOR . strtolower($lang) . DIRECTORY_SEPARATOR . strtolower($this->argument('file-name')) . '.php';
        if (file_exists($path)) {
            $this->warn("Translation file in `$lang` already exists!") ;
        } else {
            $file = fopen($path, 'w', true);
            fwrite($file, "<?php");
            fwrite($file, LINE_BREAK);
            fwrite($file, "return [");
            fwrite($file, LINE_BREAK);
            fwrite($file, TAB);
            fwrite($file, '"jafar" => "Jafar",');
            fwrite($file, LINE_BREAK);
            fwrite($file, "];");
            fwrite($file, LINE_BREAK);

            fclose($file) ;

            $this->info("Translation file in `$lang` created!") ;
        }
    }

    protected function getParentFolder()
    {
        return $this->module->getPath() . '/Resources/lang' ;
    }
}
