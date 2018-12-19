<?php

namespace Modules\Yasna\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Modules\Yasna\Classes\YasnaModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeModule extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new module.';



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module_name    = $this->argument('name');
        $author_name    = $this->askAuthorName();
        $author_email   = $this->askAuthorEmail();
        $persian_title  = $this->askPersianTitle();
        $description    = $this->askShortDescription();
        $order          = $this->askOrder();
        $parent_modules = $this->askParentModules();

        with(new YasnaModuleGenerator($module_name))
             ->setFilesystem($this->laravel['files'])
             ->setModule($this->laravel['modules'])
             ->setConfig($this->laravel['config'])
             ->setConsole($this)
             ->setForce(false)
             ->setPlain(true)
             ->setParentModules($parent_modules)
             ->setAuthorName($author_name)
             ->setAuthorEmail($author_email)
             ->setTitle($persian_title)
             ->setDescription($description)
             ->setOrder($order)
             ->setVersion('0.5.0')
             ->setReleaseDate('@TODO')
             ->generate()
        ;
    }



    /**
     * Asks Author Email
     *
     * @return string
     */
    private function askAuthorEmail()
    {
        $result = $this->ask("Your Email");

        if (!str_contains($result, '@') or !str_contains($result, '.')) {
            $result = "taha@yasna.team";
            $this->line("Ok, I'll put $result");
        }

        return $result;
    }



    /**
     * Asks Parent Modules
     *
     * @return array
     */
    private function askParentModules()
    {
        $result = $this->ask("Parent Modules (comma separated)");

        $array = explode_not_empty(',', $result);

        foreach ($array as $key => $item) {
            $item = trim($item);

            if (module($item)->isValid()) {
                $array[$key] = module($item)->getName();
                continue;
            }

            $guess = str_plural($item);
            if (module($guess)->isValid()) {
                $array[$key] = module($guess)->getName();
                continue;
            }

            $guess = str_singular($item);
            if (module($guess)->isValid()) {
                $array[$key] = module($guess)->getName();
                continue;
            }

            $this->warn("Invalid $item module. Escaped!");
            unset($array[$key]);
        }

        if (not_in_array('Yasna', $array)) {
            $array[] = "Yasna";
        }

        return $array;
    }



    /**
     * Asks Module Order
     *
     * @return int
     */
    private function askOrder()
    {
        $result = $this->ask("Module Order");

        while (!is_numeric($result) or $result < 1) {
            $result = $this->ask("Something greater than 1 please.");
        }

        return intval($result);
    }



    /**
     * Asks Author name
     *
     * @return string
     */
    private function askAuthorName()
    {
        $answer = $this->ask('Your Name');

        return title_case(trim($answer));
    }



    /**
     * Gets Persian Title
     *
     * @return string
     */
    private function askPersianTitle()
    {
        $answer = $this->ask("Persian Title");

        return trim($answer);
    }



    /**
     * Gets Persian Title
     *
     * @return string
     */
    private function askShortDescription()
    {
        return $this->ask("A Short Description");
    }



    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
             ['name', InputArgument::REQUIRED, 'the name of the module being created'],
        ];
    }



    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['plain', 'p', InputOption::VALUE_NONE, 'will generate a plain module without some resources.'],
            //['force', 'f', InputOption::VALUE_NONE, 'will forcefully make the module, even if it already exists.'],
        ];
    }
}
