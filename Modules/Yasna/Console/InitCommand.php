<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;

class InitCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initializes Yasna Core with all installed modules.';



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
     * @return void
     */
    public function handle()
    {
        $this->line('Initializing a Yasna Project... ');
        $this->deleteCaches();
        //$this->loadModuleStates();
        $this->deleteCurrentFiles();
        $this->publishModels();
        $this->spreadTraits();
        $this->storeInDatabase();

        if (!$this->option('no-check')) {
            $this->warnNonExecutedMigrations();
        }
    }



    /**
     * show warning if non-executed migrations found
     */
    protected function warnNonExecutedMigrations()
    {
        if (CheckMigrationCommand::verify()) {
            $this->line("All migrations seems to be fully executed!");
        } else {
            $this->error("Detected Non-Executed Migrations. Run `php artisan yasna:check-migrations` for more information.");
        }
    }



    /**
     * Stores module state in database
     */
    protected function storeInDatabase()
    {

        /*-----------------------------------------------
        | Make Setting, if not available already ...
        */
        setting()->new([
             'slug'  => "active_modules",
             'title' => trans('manage::statue.setting'),
        ]);

        /*-----------------------------------------------
        | Save Current Module State ...
        */
        $current_module_state = implode("|", module()->list());
        setting('active_modules')->setValue($current_module_state);
        $this->info("Active modules saved into database.");
        return;
    }



    /**
     * Loads Module states, according to database/manual list
     */
    private function loadModuleStates()
    {
        if ($this->option('modules')) {
            $this->syncWithManualOption();
            return;
        }

        if ($this->option('fresh') !== true) {
            $this->syncWithDatabase();
            return;
        }

        $this->alert("Real module state is taken into considerations.");
    }



    /**
     * sets module states according to user-entry
     */
    private function syncWithManualOption()
    {
        $user_option = $this->option('modules');

        $this->line("loading your modules: $user_option");

        $list = explode_not_empty(',', $user_option);

        $this->setModuleActivations($list);
    }



    /**
     * Sync module states with database
     */
    protected function syncWithDatabase()
    {
        /*-----------------------------------------------
        | Bypass if setting record is not available ...
        */
        if (setting()->hasnot('active_modules')) {
            $this->line("Setting record is not available. We'll save everything after the init process!");
            return;
        }

        /*-----------------------------------------------
        | Sync ...
        */
        $setting = explode("|", getSetting("active_modules"));
        $this->setModuleActivations($setting);

        $this->info("Modules Activeness synced with the available database");
    }



    /**
     * Enables/disables modules according to the received parameter
     *
     * @param array $list
     */
    private function setModuleActivations(array $list)
    {
        $modules           = module()->collection();
        $mandatory_modules = ['Yasna', 'Manage'];


        foreach ($modules as $module) {

            // Mandatory Modules...
            if (in_array($module->slug, $mandatory_modules)) {
                module($module->slug)->enable();
                continue;
            }

            // Others ...
            if (in_array($module->slug, $list)) {
                module($module->slug)->enable();
            } else {
                module($module->slug)->disable();
            }
        }
    }



    /**
     * Delete caches
     */
    protected function deleteCaches()
    {
        Artisan::call("cache:clear");
        $this->line('Caches Cleared!');
    }



    /**
     * Delete current files
     */
    protected function deleteCurrentFiles()
    {
        $path = app_path('Models');

        if (!is_dir($path)) {
            mkdir($path);
        }

        $files = glob($path . DIRECTORY_SEPARATOR . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }


        $this->info("app/Models directory is made ready.");
    }



    /**
     * Gets Active modules with their parents, and their parents of parents, and their parents of parents of parents...
     *
     * @return array
     */
    public function getActiveModulesWithParents()
    {
        $list         = module()->list();
        $more_parents = true;

        while ($more_parents) {
            $more_parents = false;

            foreach ($list as $item) {
                if (!module($item)->name) {
                    continue;
                }
                $parents = module($item)->getParentModules();
                if (is_array($parents)) {
                    foreach ($parents as $parent) {
                        if (!in_array($parent, $list)) {
                            $more_parents = true;
                            $list[]       = $parent;
                        }
                    }
                }
            }
        }

        setting('active_modules')->setCustomValue(implode('|', $list));
        return $list;
    }



    /**
     * Publish models
     */
    protected function publishModels()
    {
        $published = "";
        $failed    = "";

        foreach ($this->getActiveModulesWithParents() as $module_name) {
            $module = module($module_name);
            if (!$module->name) {
                $this->error("Error occurred while publishing models: Invalid Module Name: $module_name");
                continue;
            }
            foreach ($module->models() as $model) {
                $done = $this->makeModelFile($model, $module->getNamespace("Entities\\$model"));
                if ($done) {
                    $published .= ", $model";
                } else {
                    $failed .= ", $model";
                }
            }
        }


        /*-----------------------------------------------
        | Feedback ...
        */
        if ($published) {
            $this->info("Published:" . ltrim($published, ','));
        }
        if ($failed) {
            $this->warn("Failed to Publish:" . ltrim($published, ','));
        }
    }



    /**
     * @param $model_name
     * @param $extender
     *
     * @return bool
     */
    protected function makeModelFile($model_name, $extender)
    {
        $path = app_path('Models') . DIRECTORY_SEPARATOR . "$model_name.php";

        $file = fopen($path, 'w', true);
        fwrite($file, "<?php ");
        fwrite($file, "namespace App\\Models; ");
        fwrite($file, LINE_BREAK);
        fwrite($file, LINE_BREAK);
        fwrite($file, "class $model_name extends $extender ");
        fwrite($file, LINE_BREAK);

        fwrite($file, "{");

        fwrite($file, LINE_BREAK);
        $this->writeFieldList($extender, $file);

        fwrite($file, "}");
        fclose($file);

        return true; //<~~ Danger of Blind Feedback!
    }



    /**
     * @param $model_name
     * @param $file
     */
    protected function writeFieldList($model_namespace, $file)
    {
        $model      = new $model_namespace();
        $table_name = $model->getTable();
        $array      = Schema::getColumnListing($table_name);

        fwrite($file, LINE_BREAK . TAB . 'protected $fields_array = [');

        foreach ($array as $item) {
            fwrite($file, LINE_BREAK . TAB . TAB . "'$item',");
        }

        fwrite($file, LINE_BREAK . TAB . '];');
    }



    /**
     * Spread Traits
     */
    protected function spreadTraits()
    {
        foreach (service("yasna:traits")->read() as $service) {
            $this->injectTrait($service['to'], $service['trait']);
        }
    }



    /**
     * @param $model_name
     * @param $trait
     */
    protected function injectTrait($model_name, $trait)
    {
        $model_name  = studly_case($model_name);
        $file_path   = app_path('Models') . DIRECTORY_SEPARATOR . "$model_name.php";
        $file_exists = file_exists($file_path);

        if (!$file_exists) {
            $this->warn("Detected a disabled required module: didn't find model $model_name");
            return;
        }

        $file_content = file_get_contents($file_path);
        $line         = "use $trait;";
        $file_content = preg_replace("/{/", "{" . LINE_BREAK . TAB . $line, $file_content, 1);

        $wrote = file_put_contents($file_path, $file_content);


        if ($wrote) {
            $this->info("Added $trait to model $model_name.");
        } else {
            $this->warn("Failed to add $trait to model $model_name!");
        }
    }



    /**
     * asset links
     */
    protected function assetLinks()
    {
        Artisan::call('yasna:assets');
        $this->info("Asset shortcuts, successfully placed in [public]/modules. ");
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
             ['no-check', null , InputOption::VALUE_NONE, "run without health checks (migrations etc.)"],
        ];
    }



    /**
     * @param $module
     */
    protected function injectUserTraits($module)
    {
        /*-----------------------------------------------
        | Preparation ...
        */
        $traits       = $module->user_traits;
        $file_path    = Module::find('Yasna')->getPath() . "/Entities/User.php";
        $file_content = file_get_contents($file_path);
        $errors       = false;

        /*-----------------------------------------------
        | Loop ...
        */
        if (isset($traits) and is_array($traits)) {
            foreach ($traits as $trait) {
                $line = "use $trait;"; //<~~ To be used by $module->name" ;

                if ($module->enabled() and !str_contains($file_content, $line)) { // <~~ Add the Line
                    $file_content = preg_replace("/{/", "{\n\t" . $line, $file_content, 1);
                    $this->info("Added $trait to User model.");
                } elseif ($module->disabled() and str_contains($file_content, $trait)) { // <~~ Remove the Line
                    $file_content = str_replace("\t" . $line . "\n", null, $file_content);
                    $file_content = str_replace($line . "\n", null, $file_content);

                    if (str_contains($file_content, $trait)) {
                        $this->error("Failed to remove $trait from User model! ");
                        $errors = true;
                    } else {
                        $this->info("Removed $trait from User model.");
                    }
                }
            }
        }

        /*-----------------------------------------------
        | File Write ...
        */
        file_put_contents($file_path, $file_content);
        if ($errors) {
            $this->comment('Process completed, with at least one error.');
        } else {
            $this->info('Process completed.');
        }

        return;
    }
}
