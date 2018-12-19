<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeMigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:make-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a Migration Table, for the specified module.';

    protected $module = false;
    protected $class_name;
    protected $module_name;



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
     * Purifies command arguments.
     */
    protected function purifier()
    {
        $this->class_name  = $this->desiredTimestampBeforeMigrationFileName() . '_' . $this->argument('class_name');
        $this->module_name = $this->argument('module_name');

        $this->class_name  = snake_case($this->class_name);
        $this->module_name = studly_case($this->module_name);
        $this->module      = module($this->module_name);
    }



    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->purifier();

        if (!$this->class_name or !$this->module_name) {
            $this->error('Pattern: yasna:make-migration [class_name] [module_name]. Both are required.');
            return;
        }

        if ($this->hasClassNameTheKeywordCreate()) {
            $this->makeFolder();
            $this->makeYasnaCompatibleMigrationFile();
        } else {
            $this->call('module:make-migration', [
                 'name'   => $this->argument('class_name'),
                 'module' => $this->argument('module_name'),
            ]);
        }
    }



    /**
     * Checks if the class_name contains the keyword 'create'.
     *
     * @return bool
     */
    protected function hasClassNameTheKeywordCreate()
    {
        return str_contains($this->class_name, 'create');
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
     * Returns the desired string before the migration file name.
     *
     * @return string
     */
    protected function desiredTimestampBeforeMigrationFileName()
    {
        $current_timestamp    = date(now());
        $first_step           = str_replace(['-', ' '], '_', $current_timestamp);
        $final_desired_string = str_replace(':', '', $first_step);

        return $final_desired_string;
    }



    /**
     * Returns the desired class name in studly case form.
     *
     * @return string
     */
    protected function desiredClassName()
    {
        return substr(studly_case($this->class_name), 14);
    }



    /**
     * Returns the desired schema name.
     *
     * @return string
     */
    protected function desiredSchemaName()
    {
        return strtolower(str_before(str_after($this->class_name, 'create_'), '_table'));
    }



    /**
     * Specifies the folder path.
     *
     * @return mixed
     */
    protected function folderPath()
    {
        return $this->module->getPath('Database' . DIRECTORY_SEPARATOR . 'Migrations');
    }



    /**
     * Makes the folder path if it already does not exist.
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
     * Makes the yasna compatible migration file.
     */
    public function makeYasnaCompatibleMigrationFile()
    {
        $path = $this->folderPath() . DIRECTORY_SEPARATOR . $this->class_name . '.php';
        if (file_exists($path)) {
            $this->warn("File already exists!");
        } else {
            $file = fopen($path, 'w', true);
            fwrite($file, "<?php ");
            fwrite($file, LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, 'use Illuminate\Support\Facades\Schema;' . LINE_BREAK);
            fwrite($file, 'use Illuminate\Database\Schema\Blueprint;' . LINE_BREAK);
            fwrite($file, 'use Illuminate\Database\Migrations\Migration;' . LINE_BREAK);
            fwrite($file, LINE_BREAK);
            fwrite($file, "class " . $this->desiredClassName() . " extends Migration");
            fwrite($file, LINE_BREAK);
            fwrite($file, "{" . LINE_BREAK);
            fwrite($file, TAB . '/**' . LINE_BREAK);
            fwrite($file, TAB . ' * Run the migrations.' . LINE_BREAK);
            fwrite($file, TAB . ' *' . LINE_BREAK);
            fwrite($file, TAB . ' * @return void' . LINE_BREAK);
            fwrite($file, TAB . ' */' . LINE_BREAK);
            fwrite($file, TAB . 'public function up()' . LINE_BREAK);
            fwrite($file, TAB . '{' . LINE_BREAK);
            fwrite($file, TAB . TAB . 'Schema::create(\'' . $this->desiredSchemaName() . '\', function'
                 . ' (Blueprint $table) {' . LINE_BREAK);
            fwrite($file, TAB . TAB . TAB . '$table->increments(\'id\');' . LINE_BREAK);
            fwrite($file, TAB . TAB . TAB . LINE_BREAK);
            fwrite($file, TAB . TAB . TAB . '$table->timestamps();' . LINE_BREAK);
            fwrite($file, TAB . TAB . TAB . 'yasna()->additionalMigrations($table);' . LINE_BREAK);
            fwrite($file, TAB . TAB . '});' . LINE_BREAK);
            fwrite($file, TAB . '}' . LINE_BREAK . LINE_BREAK . LINE_BREAK . LINE_BREAK);
            fwrite($file, TAB . '/**' . LINE_BREAK);
            fwrite($file, TAB . ' * Reverse the migrations.' . LINE_BREAK);
            fwrite($file, TAB . ' *' . LINE_BREAK);
            fwrite($file, TAB . ' * @return void' . LINE_BREAK);
            fwrite($file, TAB . ' */' . LINE_BREAK);
            fwrite($file, TAB . 'public function down()' . LINE_BREAK);
            fwrite($file, TAB . '{' . LINE_BREAK);
            fwrite($file, TAB . TAB . 'Schema::dropIfExists(\'' . $this->desiredSchemaName() . '\');'
                 . LINE_BREAK);
            fwrite($file, TAB . '}' . LINE_BREAK);

            fwrite($file, "}");
            fwrite($file, LINE_BREAK);

            fclose($file);

            $this->info("$path is created!");
        }
    }
}
