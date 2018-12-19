<?php

namespace Modules\Trans\services\TransDiff;


trait TransOverallTrait
{


    /**
     * return all unique keys from out of all modules in resources/lang
     * "ar"=> ["auth.php","pagination.php","validation.php"]
     *
     * @return array
     */
    public function getAllKeys()
    {
        $trans_files = $this->getTransFileName();
        $all_keys    = $this->overallGetAllKeysFromAllDri($trans_files);

        return $all_keys;
    }



    /**
     * Return the list of trans file name out of all modules.
     *
     * @return array
     */
    public function getTransFileName()
    {
        $path = resource_path('lang');

        $directories = []; // ['en','fa']
        foreach (scandir($path) as $dir) {
            $path = resource_path('lang' . DIRECTORY_SEPARATOR . $dir);
            if (is_dir($path) && in_array($dir, $this->all_locales)) {
                array_push($directories, $dir);
            }
        }

        $array = [];
        foreach ($directories as $dr) {
            $files      = $this->getFileNameFromAnyLang($dr);
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
    protected function getFileNameFromAnyLang($directory)
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
     *
     * @param array $langs
     *
     * @return array
     */
    public function overallGetAllKeysFromAllDri($langs)
    {
        $dot_keys = [];
        foreach ($langs as $key => $value) {
            foreach ($value as $trans_file_name) {

                $trans_file_name = explode('.', $trans_file_name)[0];

                $trans = trans($trans_file_name, [], $key);

                if (is_array($trans)) {
                    foreach (array_dot($trans) as $tran_key => $tran_value) {
                        array_push($dot_keys, $trans_file_name . '.' . $tran_key);
                    }
                }
            }
        }
        return (array)array_unique($dot_keys);
    }

}
