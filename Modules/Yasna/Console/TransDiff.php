<?php

namespace Modules\Yasna\Console;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class TransDiff extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'yasna:trans-diff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find absent keys in trans files';
    protected $module      = false;
    protected $module_name;
    protected $module_path;
    protected $locales;
    protected $option_lang = null;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->locales = setting('site_locales')->gain();

        parent::__construct();
    }



    /**
     * Purifier the module names from the command line.
     */
    protected function purifier()
    {
        $this->module_name = strtolower($this->argument('module_name'));
        $this->module      = module($this->module_name);

        $this->module_path = module($this->module_name)->getPath('Resources' . DIRECTORY_SEPARATOR . 'lang');

    }



    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        /**
         * if run command yasna:trans-diff overall
         * ------------------------------------------------
         */
        if ($this->argument('module_name') && strtolower($this->argument('module_name')) == 'overall') {
            $this->overallCommand();
        }


        if ($this->argument('module_name') && $this->ModuleExist($this->argument('module_name'))) {
            $this->purifier();
            $this->specifyModuleCommand();
        }

        if (!$this->argument('module_name')) {

            $this->allModulesCommand();
        }
    }



    /**
     *  Handle with overall parameter and options
     */
    protected function overallCommand()
    {
        if ($this->option('lang')) {
            if (in_array($this->option('lang'), $this->locales)) {
                $this->option_lang = $this->option('lang');
            }
        }

        if ($this->option('export')) {
            $this->diffOverAll($cli = false, $export = true, $count = false);
        }

        if ($this->option('count')) {
            $this->diffOverAll($cli = false, $export = false, $count = true);
        }

        if (!$this->option('count') && !$this->option('export')) {
            $this->diffOverAll($cli = true, $export = false, $count = false);
        }

    }



    /**
     *  Handle with specified module name and parameter
     */
    protected function specifyModuleCommand()
    {

        if ($this->option('lang')) {
            if (in_array($this->option('lang'), $this->locales)) {
                $this->option_lang = $this->option('lang');
            }
        }

        if ($this->option('export')) {
            $this->diffSingleModule($this->module_name, $cli = false, $export = true, $count = false);
        }

        if ($this->option('count')) {
            $this->diffSingleModule($this->module_name, $cli = false, $export = false, $count = true);
        }

        if (!$this->option('count') && !$this->option('export')) {
            $this->diffSingleModule($this->module_name, $cli = true, $export = false, $count = false);
        }
    }



    /**
     *  Handle without module name with options
     */
    protected function allModulesCommand()
    {
        if ($this->option('lang')) {
            if (in_array($this->option('lang'), $this->locales)) {
                $this->option_lang = $this->option('lang');
            }
        }

        if ($this->option('export')) {
            $this->diffAllModule($cli = false, $export = true, $count = false);
        }

        if ($this->option('count')) {
            $this->diffAllModule($cli = false, $export = false, $count = true);
        }

        if (!$this->option('count') && !$this->option('export')) {
            $this->diffAllModule($cli = true, $export = false, $count = false);
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
             ['count', null, InputOption::VALUE_NONE, 'return the total number of problems', null],
             ['export', null, InputOption::VALUE_NONE, 'write the result in a file ', null],
             ['lang', null, InputOption::VALUE_REQUIRED, 'write the result in a file ', null],
        ];
    }



    /**
     * find absent keys in specified module.
     *
     * @param string  $module_name
     * @param boolean $cli
     * @param boolean $export
     * @param boolean $count
     */
    protected function diffSingleModule($module_name, $cli, $export, $count)
    {
        $arr          = $this->getTransFileName($module_name);
        $all_dir_keys = $this->getAllKeysFromAllDri($module_name, $arr);
        $diff         = $this->getDiffKeys($module_name, $all_dir_keys, $arr);


        if ($cli) {
            $this->viewDiffOnCLI($module_name, $diff);
        }

        if ($export) {
            $this->exportAbsentKeysToExcel($module_name, $arr, $diff);
        }

        if ($count) {
            $this->info('Absent keys in ' . $module_name . ' module is : ' . count($diff));
        }

    }



    /**
     *  find absent keys in all modules.
     *
     * @param boolean $cli
     * @param boolean $export
     * @param boolean $count
     */
    protected function diffAllModule($cli, $export, $count)
    {
        $modules = module()->list();
        foreach ($modules as $module) {

            $this->diffSingleModule(strtolower($module), $cli, $export, $count);

        }
    }



    /**
     * Return the list of trans file name in any lang.
     *
     * @param string $module_name
     *
     * @return array
     */
    protected function getTransFileName($module_name)
    {
        $directories = $this->getLangDirectories($module_name); // ['fa', 'en']

        $array = [];
        foreach ($directories as $dr) {
            $files      = $this->getLangFiles($module_name, $dr);
            $array[$dr] = $files;
        }

        return $array;
    }



    /**
     * return exists directory in Resources/lang/
     *
     * @param string $module_name
     *
     * @return array
     */
    protected function getLangDirectories($module_name)
    {
        $module = module($module_name);
        $path   = $module->getPath('Resources' . DIRECTORY_SEPARATOR . 'lang');
        $dirs   = [];
        foreach (scandir($path) as $dir) {
            if (in_array($dir, $this->locales)) {
                array_push($dirs, $dir);
            }
        }
        return $dirs;
    }



    /**
     * return array of file name from specified lang directory.
     *
     * @param string $module_name
     * @param string $directory
     *
     * @return array
     */
    protected function getLangFiles($module_name, $directory)
    {
        $module = module($module_name);
        $path   = $module->getPath('Resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $directory);

        $files = [];
        foreach (array_diff(scandir($path), ['.', '..']) as $file) {
            if (count(scandir($path)) >= 3) {
                array_push($files, $file);
            }
        }
        return $files;
    }



    /**
     * return all trans keys from specified module
     * example: users:fa.seeders.dynamic.process
     *
     * @param string $module_name
     * @param array  $langs
     *
     * @return array
     */
    protected function getAllKeysFromAllDri($module_name, $langs)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            foreach ($value as $trans_file_name) {

                $trans_file_name = explode('.', $trans_file_name)[0];

                $trans = trans($module_name . "::" . $trans_file_name, [], $key);

                if (is_array($trans)) {
                    foreach (array_dot($trans) as $tran_key => $tran_value) {
                        array_push($dot_keys, $module_name . '::' . $key . '.' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }
        return (array)$dot_keys;

    }



    /**
     * return all trans keys from one lang directory.
     * example: users:fa.seeders.dynamic.process
     *
     * @param string $module_name
     * @param array  $langs
     * @param string $lang
     *
     * @return array
     */
    protected function getAllKeysFromOneDri($module_name, $langs, $lang)
    {

        $dot_keys = [];
        foreach ($langs as $key => $value) {
            if ($key == $lang) {
                foreach ($value as $trans_file_name) {
                    $trans_file_name = explode('.', $trans_file_name)[0];
                    $trans           = array_dot(trans($module_name . "::" . $trans_file_name, [], $key));
                    foreach ($trans as $tran_key => $tran_value) {
                        array_push($dot_keys, $module_name . '::' . $key . '.' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }

        return (array)$dot_keys;
    }



    /**
     * return all trans keys from one lang directory.
     * example: users:fa.seeders.dynamic.process
     *
     * @param string $module_name
     * @param array  $langs
     * @param string $lang
     *
     * @return array
     */
    protected function getAllKeyValue($module_name, $langs, $lang)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            if ($key == $lang) {
                foreach ($value as $trans_file_name) {
                    $trans_file_name = explode('.', $trans_file_name)[0];
                    $trans           = array_dot(trans($module_name . "::" . $trans_file_name, [], $key));
                    foreach ($trans as $tran_key => $tran_value) {
                        $dot_keys[$module_name . '::' . $key . '.' . $trans_file_name . '.' . $tran_key] = $tran_value;

                    }
                }
            }
        }

        return (array)$dot_keys;
    }



    /**
     * return absent keys from specified module
     *
     * @param string $module_name
     * @param array  $all_dir_keys
     * @param array  $langs
     *
     * @return array
     */
    protected function getDiffKeys($module_name, $all_dir_keys, $langs)
    {
        $diff_keys    = [];
        $option_langs = ($this->option_lang) ? (array)$this->option_lang : $this->locales;
        foreach ($option_langs as $lang) {
            $one_dir_keys = $this->getAllKeysFromOneDri($module_name, $langs, $lang);
            foreach ($all_dir_keys as $key) {
                $key = str_replace($module_name . '::' . $this->getLocal($key), $module_name . '::' . $lang, $key);
                if (!in_array($key, $one_dir_keys)) {
                    array_push($diff_keys, $key);
                }
            }
        }
        return (array)$diff_keys;
    }



    /**
     *  get locale from mixed words "users:en.seeders.dynamic.search"
     *
     * @param string $key
     *
     * @return string
     */
    protected function getLocal($key)
    {
        $lang = explode('.', $key);
        $lang = explode('::', $lang[0]);

        return $lang[1];
    }



    /**
     * show diff keys on cli
     *
     * @param string $module_name
     * @param array  $diff
     */
    protected function viewDiffOnCLI($module_name, $diff)
    {
        $spacer  = ' ';
        $body    = [];
        $headers = [
             '#',
             '|',
             'Absent vars in: ' . $module_name,
        ];
        foreach ($diff as $key => $value) {
            $body[] = [
                 $key + 1 . $spacer,
                 '|',
                 $value,
            ];
        }
        array_push($body, [
             '===' . $spacer,
             '',
             '====================',
        ]);
        $this->table($headers, $body, 'compact');
    }



    /**
     * Export excel file and store in storage directory.
     *
     * @param string $module_name
     * @param array  $langs
     * @param array  $array
     */
    protected function exportAbsentKeysToExcel($module_name, $langs, $array)
    {
        if (count($array) == 0) {
            return;
        }
        $excel = Excel::create('absent_keys_in_' . $module_name . '_module_' . time(),
             function ($excel) use ($array, $module_name, $langs) {
                 $excel->sheet('sheet', function ($sheet) use ($array, $module_name, $langs) {

                     $header = [
                          '#',
                          'key',
                     ];
                     foreach ($this->locales as $lang) {
                         array_push($header, $lang);
                     }
                     $rows = [];
                     $sheet->appendRow($header);

                     foreach ($array as $i => $key_) {
                         $key    = str_replace($module_name . '::' . $this->getLocal($key_) . '.', $module_name . '::',
                              $key_);
                         $row[0] = $i;
                         $row[1] = $key;

                         foreach ($this->locales as $i => $lang) {
                             $key         = str_replace($module_name . '::' . $this->getLocal($key_) . '.',
                                  $module_name . '::' . $lang . '.', $key_);
                             $txt         = $this->trans($module_name, $langs, $lang, $key);
                             $row[$i + 2] = $txt;
                         }
                         array_push($rows, $row);
                     }
                     foreach ($rows as $row) {
                         $sheet->appendRow([
                              (isset($row[0])) ? $row[0] : '',
                              (isset($row[1])) ? $row[1] : '',
                              (isset($row[2])) ? $row[2] : '',
                              (isset($row[3])) ? $row[3] : '',
                              (isset($row[4])) ? $row[4] : '',
                              (isset($row[5])) ? $row[5] : '',
                              (isset($row[6])) ? $row[6] : '',
                         ]);
                     }
                 });
             })->store('xls', false, true)
        ;

        $this->info($module_name . ' : ' . $excel['full']);
        $this->info('==============================');

    }



    /**
     * Check the  key as exist in list of trans
     *
     * @param string $module_name
     * @param array  $langs
     * @param string $lang
     * @param string $key
     *
     * @return bool
     */
    protected function isExist($module_name, $langs, $lang, $key)
    {
        $one_dir_keys = $this->getAllKeysFromOneDri($module_name, $langs, $lang);

        if (in_array('users::fa.seeders.dynamic.carts', $one_dir_keys)) {
            return true;
        }
        return false;
    }



    /**
     * translate the key if exist.
     *
     * @param string $module_name
     * @param array  $langs
     * @param string $lang
     * @param string $key
     *
     * @return string
     */
    protected function trans($module_name, $langs, $lang, $key)
    {
        $keys_values = $this->getAllKeyValue($module_name, $langs, $lang);
        if (array_key_exists($key, $keys_values)) {

            return $keys_values[$key];
        }
        return '';
    }



    /**
     * Check module is available or not
     *
     * @param string $module_name
     *
     * @return bool
     */
    protected function ModuleExist($module_name)
    {
        if ($module_name == 'overall') {
            return false;
        } elseif (module()->isDefined($module_name)) {
            if (module($module_name)->getStatus()) {
                return true;
            } else {
                $this->error('The Module ' . module($module_name)->getStudlyName() . ' is Disable.');
                return false;
            }
        } else {
            $this->error('The Module name is not correct.');
            return false;
        }
    }



    /**
     * find absent keys out of all modules.
     *
     * @param boolean $cli
     * @param boolean $export
     * @param boolean $count
     */
    protected function diffOverAll($cli, $export, $count)
    {

        $arr = $this->overallGetTransFileName();

        $all_dir_keys = $this->overallGetAllKeysFromAllDri($arr);

        $diff = $this->overallGetDiffKeys($all_dir_keys, $arr);

        if ($cli) {
            $this->viewDiffOnCLI('overall', $diff);
        }

        if ($export) {
            $this->overallExportAbsentKeysToExcel($arr, $diff);
        }

        if ($count) {
            $this->info('Absent keys in resources/lang is : ' . count($diff));
        }

    }



    /**
     * Return the list of trans file name out of all modules.
     *
     * @return array
     */
    protected function overallGetTransFileName()
    {
        $path = resource_path('lang');

        $directories = []; // ['en','fa']
        foreach (scandir($path) as $dir) {
            if (in_array($dir, $this->locales)) {
                array_push($directories, $dir);
            }
        }
        $array = [];
        foreach ($directories as $dr) {
            $files      = $this->overallGetLangFiles($dr);
            $array[$dr] = $files;
        }
        return $array;
    }



    /**
     * return array of file name from out of all modules in resources/lang
     *
     * @param string $directory
     *
     * @return array
     */
    protected function overallGetLangFiles($directory)
    {
        $path = resource_path('lang' . DIRECTORY_SEPARATOR . $directory);

        $files = [];
        foreach (array_diff(scandir($path), ['.', '..']) as $file) {
            if (count(scandir($path)) >= 3) {
                array_push($files, $file);

            }
        }
        return $files;
    }



    /**
     * return all trans keys from resources/lang dir
     * example: passwords.password
     *
     * @param array $langs
     *
     * @return array
     */
    protected function overallGetAllKeysFromAllDri($langs)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            foreach ($value as $trans_file_name) {

                $trans_file_name = explode('.', $trans_file_name)[0];

                $trans = trans($trans_file_name, [], $key);

                if (is_array($trans)) {
                    foreach (array_dot($trans) as $tran_key => $tran_value) {
                        array_push($dot_keys, $key . '.' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }
        return (array)$dot_keys;
    }



    /**
     * return all trans keys from one lang directory.
     * example: passwords.password
     *
     * @param array  $langs
     * @param string $lang
     *
     * @return array
     */
    protected function overallGetAllKeysFromOneDri($langs, $lang)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            if ($key == $lang) {
                foreach ($value as $trans_file_name) {
                    $trans_file_name = explode('.', $trans_file_name)[0];
                    $trans           = array_dot(trans($trans_file_name, [], $key));
                    foreach ($trans as $tran_key => $tran_value) {
                        array_push($dot_keys, $key . '.' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }
        return (array)$dot_keys;
    }



    /**
     * get lang from key "en.passwords.password"
     *
     * @param string $key
     *
     * @return string
     */
    protected function overallGetLocal($key)
    {
        $lang = explode('.', $key);
        return $lang[0];
    }



    /**
     * return absent keys from out of all modules in resources/lang
     *
     * @param array $all_dir_keys
     * @param array $langs
     *
     * @return array
     */
    protected function overallGetDiffKeys($all_dir_keys, $langs)
    {
        $diff_keys    = [];
        $option_langs = ($this->option_lang) ? (array)$this->option_lang : $this->locales;

        foreach ($option_langs as $lang) {
            $one_dir_keys = $this->overallGetAllKeysFromOneDri($langs, $lang);
            foreach ($all_dir_keys as $key) {
                $key = substr($key, 3, strlen($key));


                if (!in_array($lang . '.' . $key, $one_dir_keys)) {
                    array_push($diff_keys, $lang . '.' . $key);
                }
            }
        }
        return (array)$diff_keys;
    }



    /**
     * Export excel file and store in storage directory.
     *
     * @param array $langs
     * @param array $array
     */
    protected function overallExportAbsentKeysToExcel($langs, $array)
    {

        if (count($array) == 0) {
            return;
        }
        $excel = Excel::create('absent_keys_in_overall_module_' . time(),
             function ($excel) use ($array, $langs) {
                 $excel->sheet('sheet', function ($sheet) use ($array, $langs) {

                     $header = [
                          '#',
                          'key',
                     ];
                     foreach ($this->locales as $lang) {
                         array_push($header, $lang);
                     }
                     $rows = [];
                     $sheet->appendRow($header);
                     foreach ($array as $i => $key_) {

                         $key    = str_replace($this->overallGetLocal($key_) . '.', '', $key_);
                         $row[0] = $i;
                         $row[1] = $key;
                         foreach ($this->locales as $i => $lang) {
                             $key         = str_replace($this->overallGetLocal($key_) . '.', '', $key_);
                             $txt         = $this->overallTrans($langs, $lang, $key);
                             $row[$i + 2] = $txt;
                         }
                         array_push($rows, $row);
                     }
                     foreach ($rows as $row) {
                         $sheet->appendRow([
                              (isset($row[0])) ? $row[0] : '',
                              (isset($row[1])) ? $row[1] : '',
                              (isset($row[2])) ? $row[2] : '',
                              (isset($row[3])) ? $row[3] : '',
                              (isset($row[4])) ? $row[4] : '',
                              (isset($row[5])) ? $row[5] : '',
                              (isset($row[6])) ? $row[6] : '',
                         ]);
                     }
                 });
             })->store('xls', false, true)
        ;

        $this->info('overall : ' . $excel['full']);
        $this->info('==============================');
    }



    /**
     * translate the key if exist.
     *
     * @param array  $langs
     * @param string $lang
     * @param string $key
     *
     * @return string
     */
    protected function overallTrans($langs, $lang, $key)
    {
        $keys_values = $this->getAllKeyValueOverall($langs, $lang);
        if (array_key_exists($key, $keys_values)) {
            return $keys_values[$key];
        }
        return '';
    }



    /**
     * return all trans keys from one directory in resources/lang.
     * example: fa.seeders.dynamic.process
     *
     * @param array  $langs
     * @param string $lang
     *
     * @return array
     */
    protected function getAllKeyValueOverall($langs, $lang)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            if ($key == $lang) {
                foreach ($value as $trans_file_name) {
                    $trans_file_name = explode('.', $trans_file_name)[0];
                    $trans           = array_dot(trans($trans_file_name, [], $key));
                    foreach ($trans as $tran_key => $tran_value) {
                        $dot_keys[$trans_file_name . '.' . $tran_key] = $tran_value;
                    }
                }
            }
        }
        return (array)$dot_keys;
    }
}
