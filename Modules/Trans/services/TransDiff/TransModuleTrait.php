<?php

namespace Modules\Trans\services\TransDiff;

trait TransModuleTrait
{

    /**
     * Check module is available or not
     *
     * @param string $module_name
     *
     * @return bool
     */
    public function moduleIsActive($module_name)
    {
        if (module()->isDefined($module_name)) {
            return true;
        } else {
            return false;
        }
    }



    /**
     * return all trans keys from specified module and all locales
     * example: ['yasna::domains.php.domains','yasna::domains.php.reflections']
     *
     * @param string $module_name
     *
     * @return array
     */
    public function getModuleAllTransKeys($module_name)
    {
        $langs           = $this->getModuleLangDirWithTransFile($module_name);
        $trans_array_dot = [];

        foreach ($langs as $lang => $value) {
            foreach ($value as $trans_file_name) {
                $trans           = $this->getModuleTransFromFile($module_name, $trans_file_name, $lang);
                $trans_file_name = explode('.', $trans_file_name)[0];
                if (is_array($trans)) {
                    foreach (array_dot($trans) as $tran_key => $tran_value) {
                        array_push($trans_array_dot, $module_name . '::' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }

        $trans_keys = array_unique($trans_array_dot);
        return $trans_keys;
    }



    /**
     * return all trans keys from specified module with locale
     * example: ['en'=>['yasna::domains.php.domains','yasna::domains.php.reflections']]
     *
     * @param string $module_name
     *
     * @return array
     */
    public function getModuleAllTransKeysOnLang($module_name)
    {
        $langs           = $this->getModuleLangDirWithTransFile($module_name);
        $trans_array     = [];
        $trans_array_dot = [];

        foreach ($langs as $lang => $value) {

            foreach ($value as $trans_file_name) {
                $trans           = $this->getModuleTransFromFile($module_name, $trans_file_name, $lang);
                $trans_file_name = explode('.', $trans_file_name)[0];
                if (is_array($trans)) {
                    foreach (array_dot($trans) as $tran_key => $tran_value) {
                        array_push($trans_array_dot, $module_name . '::' . $trans_file_name . '.' . $tran_key);
                    }
                }
            }
            $trans_array[$lang] = $trans_array_dot;
            $trans_array_dot    = [];
        }


        return (array)$this->merge($trans_array);
    }



    /**
     * Return the list of locale dir with trans file in any lang.
     * Example:  ['fa' => ['domains.php', 'lang.php'], 'en' => ['domains.php', 'lang.php']]
     *
     * @param string $module_name
     *
     * @return array
     */
    public function getModuleLangDirWithTransFile($module_name)
    {
        $directories = $this->getModuleLangDir($module_name); // ['fa', 'en']
        $array       = [];
        foreach ($directories as $dr) {
            $files      = $this->getModuleLangFiles($module_name, $dr);
            $array[$dr] = $files;
        }

        return $array;
    }



    /**
     * return array of file name from specified lang directory.
     * Example:  ['domains.php', 'lang.php', 'seeders.php']
     *
     * @param string $module_name
     * @param string $dir
     *
     * @return array
     */
    public function getModuleLangFiles($module_name, $dir)
    {
        $module = module($module_name);
        $files  = [];
        $path   = $module->getPath('Resources' . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . $dir);

        if (!is_dir($path)) {
            return [];
        }
        foreach (scandir($path) as $file_name) {
            if (is_file($path . DIRECTORY_SEPARATOR . $file_name)) {
                array_push($files, $file_name);
            }
        }
        return $files;
    }



    /**
     * Return exists directory in Resources/lang/
     * Example:  ['fa', 'en']
     *
     * @param string $module_name
     *
     * @return array
     */
    public function getModuleLangDir($module_name)
    {
        $module      = module($module_name);
        $path        = $module->getPath('Resources' . DIRECTORY_SEPARATOR . 'lang');
        $locales_dir = [];

        if (is_dir($path)) {
            foreach (scandir($path) as $dir) {
                if (in_array($dir, $this->all_locales)) {
                    array_push($locales_dir, $dir);
                }
            }
        }

        return (array)$locales_dir;
    }



    /**
     * Return trans key => value from specified file and locale
     * Example:  ['domain'=>'Domain', 'main'=>'Main Domain']
     *
     * @param string $module_name
     * @param string $trans_file_name
     * @param string $lang
     *
     * @return array
     */
    public function getModuleTransFromFile($module_name, $trans_file_name, $lang)
    {
        // remove extension domains.php -> domains
        $trans_file_name = explode('.', $trans_file_name)[0];
        $trans           = trans($module_name . "::" . $trans_file_name, [], $lang);

        return (array)$trans;
    }


    /**
     * return all trans keys from one lang directory.
     *
     * @param string $module_name
     * @param string $custom_lang
     *
     * @return array
     */
    protected function getModuleAllKeyValue($module_name, $custom_lang)
    {

        $langs           = $this->getModuleLangDirWithTransFile($module_name);
        $trans_key_value = [];

        foreach ($langs as $lang => $value) {
            if ($lang == $custom_lang) {
                foreach ($value as $trans_file_name) {
                    $trans_file_name = explode('.', $trans_file_name)[0];
                    $trans           = array_dot(trans($module_name . "::" . $trans_file_name, [], $lang));
                    foreach ($trans as $tran_key => $tran_value) {
                        $trans_key_value[$module_name . '::' . $trans_file_name . '.' . $tran_key] = $tran_value;
                    }
                }
            }
        }
        return (array)$trans_key_value;
    }



    /**
     * convert array with sub array to flat and unique
     *
     * @param array $trans_array
     *
     * @return array
     */
    public function merge($trans_array)
    {
        $data               = [];
        $whole_unique_trans = array_unique(array_flatten($trans_array));

        foreach ($trans_array as $lang => $trans) {
            $data[$lang] = $whole_unique_trans;
        }
        return $data;

    }
}
