<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class AssetsShortcutsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates shortcuts for all module assets.';

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
     */
    public function handle()
    {
        $this->assetLinks() ;
    }

    protected function assetLinks()
    {
        $filesystem = new Filesystem() ;
        /*-----------------------------------------------
        | Delete Current Files ...
        */
        $path = public_path("modules") ;

        if (!is_dir($path)) {
            mkdir($path);
        }

        $files = glob($path . DIRECTORY_SEPARATOR . '*');
        foreach ($files as $file) {
            if (is_file($file) or is_link($file)) {
                unlink($file);
            }
        }


        /*-----------------------------------------------
        | Make new shortcuts for each live module ...
        */
        foreach (module()->list() as $module_name) {
            $target = module($module_name)->getPath('Assets') ;
            $link = public_path("modules" . DIRECTORY_SEPARATOR . strtolower($module_name)) ;

            $filesystem->link($target, $link) ;
            $this->info("Asset created for [$module_name]");
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
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
