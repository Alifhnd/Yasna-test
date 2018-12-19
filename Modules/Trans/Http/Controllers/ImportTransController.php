<?php

namespace Modules\Trans\Http\Controllers;

use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Trans\Http\Requests\ImportExcelRequest;
use Modules\Yasna\Services\YasnaController;


class ImportTransController extends YasnaController
{
    protected $base_model  = 'Trans';
    protected $view_folder = 'trans::downstream';



    /**
     * show modal for import excel file
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function importModal()
    {
        return view('trans::excel.import');
    }



    /**
     * Import excel file
     *
     * @param ImportExcelRequest $request
     *
     * @return string
     * @throws \Throwable
     */
    public function import(ImportExcelRequest $request)
    {
        $file    = $request->file("file");
        $result  = Excel::load($file)->get();
        $data    = $this->purifyExcelResult($result);
        $locales = $data['locales'];
        $modules = $data['modules'];
        config(['app.fallback_locale' => getLocale()]);
        if ($this->isNotValidExcelSheet($modules, $locales)) {
            return $this->jsonFeedback(trans('trans::downstream.excel.data_error'));
        }

        $data = [];
        foreach ($modules as $module_name => $module_trans) {
            if ($module_name == 'overall') {
                $data[$module_name] = $this->getPurifyExcelDataInOverall($module_trans, $locales);
            } else {
                $data[$module_name] = $this->getPurifyExcelDataInModule($module_name, $module_trans, $locales);
            }
        }

        $this->writeToTransFile($data, $locales);

        return $this->jsonAjaxSaveFeedback(true, [
             'success_refresh' => true,
        ]);
    }



    /**
     * purify the excel data in specified module
     *
     * @param string $module_name
     * @param array  $module_trans
     * @param array  $locales
     *
     * @return array
     */
    public function getPurifyExcelDataInModule($module_name, $module_trans, $locales)
    {
        $data              = [];
        $locale_key        = [];
        $module_name       = strtolower($module_name);
        $module_trans_keys = array_pluck($module_trans, 'key');
        $file_names        = $this->getModuleFileName($module_trans_keys, $module_name);

        foreach ($file_names as $file_name) {
            foreach ($locales as $locale) {
                $locale_key[$locale] = [];
                foreach ($module_trans_keys as $key) {
                    if (str_contains($key, $module_name . '::' . $file_name)) {
                        $blank_key = str_replace($module_name . '::' . $file_name . '.', '', $key);

                        $trans[$blank_key] = $this->getTrans($module_trans, $key, $locale);
                    }
                }
                array_push($locale_key[$locale], $trans);
                $trans = [];
            }
            $data[$file_name] = [];
            array_push($data[$file_name], $locale_key);
        }

        return $data;
    }



    /**
     * purify the excel data in overall
     *
     * @param array $module_trans
     * @param array $locales
     *
     * @return array
     */
    public function getPurifyExcelDataInOverall($module_trans, $locales)
    {
        $data        = [];
        $locale_key  = [];
        $module_name = 'overall';
        $trans_keys  = array_pluck($module_trans, 'key');
        $file_names  = $this->getModuleFileNameOverlall($trans_keys);

        foreach ($file_names as $file_name) {
            foreach ($locales as $locale) {
                $locale_key[$locale] = [];
                foreach ($trans_keys as $key) {
                    if (str_contains($key, $file_name)) {
                        $blank_key         = str_replace($file_name . '.', '', $key);
                        $trans[$blank_key] = $this->getTrans($module_trans, $key, $locale);
                    }
                }
                array_push($locale_key[$locale], $trans);
                $trans = [];
            }
            $data[$file_name] = [];
            array_push($data[$file_name], $locale_key);
        }

        return $data;
    }



    /**
     * return trans of key in specified locale
     *
     * @param array  $module_trans
     * @param string $key
     * @param array  $locale
     *
     * @return string
     */
    public function getTrans($module_trans, $key, $locale)
    {
        foreach ($module_trans as $trans) {
            if ($trans['key'] == $key) {
                return $trans[$locale] ?? '';
            }
        }
    }



    /**
     * return name of trans files in specified module
     *
     * @param array  $module_trans_keys
     * @param string $module_name
     *
     * @return array
     */
    public function getModuleFileName($module_trans_keys, $module_name)
    {
        $file_names = [];

        foreach ($module_trans_keys as $key) {
            if (str_contains($key, $module_name . '::')) {
                $blank_key = explode($module_name . '::', $key);
                $file_name = explode('.', $blank_key[1])[0];
                array_push($file_names, $file_name);
            }
        }
        $file_names = array_unique($file_names);

        return $file_names;
    }



    /** return name of trans files in overall
     *
     * @param array array $trans_keys
     *
     * @return array
     */
    public function getModuleFileNameOverlall($trans_keys)
    {
        $file_names = [];

        foreach ($trans_keys as $key) {
            if (str_contains($key, '.')) {
                $file_name = explode('.', $key)[0];
                array_push($file_names, $file_name);
            }
        }
        $file_names = array_unique($file_names);

        return $file_names;
    }



    /**
     * write to trans file
     *
     * @param array $data
     * @param array $locales
     *
     * @return string
     * @throws \Throwable
     */
    public function writeToTransFile($data, $locales)
    {
        foreach ($data as $module_name => $files) {
            if ($module_name == 'overall') {
                $this->writeToOverallTrans($files);
            } else {
                $this->writeToModuleTrans($module_name, $files);
            }
        }
    }



    /**
     * write to module trans file
     *
     * @param string $module_name
     * @param array  $files
     *
     * @throws \Throwable
     */
    public function writeToModuleTrans($module_name, $files)
    {
        $slash = DIRECTORY_SEPARATOR;
        foreach ($files as $file_name => $locales) {
            foreach ($locales[0] as $lang => $trans) {
                $path = module($module_name)->getPath('Resources' . $slash . 'lang' . $slash . $lang . $slash . $file_name . '.php');
                $dir  = module($module_name)->getPath('Resources' . $slash . 'lang' . $slash . $lang);

                if (is_array(trans(strtolower($module_name) . "::" . $file_name, [], $lang))) {
                    $current_trans = array_dot(trans(strtolower($module_name) . "::" . $file_name, [], $lang));
                    $trans         = array_merge($current_trans, $trans[0]);

                    foreach ($trans as $key => $value) {
                        $value = str_replace('"', "'", $value);
                        array_set($array, $key, $value);
                    }
                    if (!is_dir($dir)) {
                        File::makeDirectory($dir);
                    }
                    File::delete($path);
                    $trans_file = view('trans::excel.trans', compact('array'))->render();
                    File::put($path, $trans_file);
                    unset($array);
                }
            }
        }
    }



    /**
     * write to overall trans file
     *
     * @param array $files
     *
     * @throws \Throwable
     */
    public function writeToOverallTrans($files)
    {
        $slash = DIRECTORY_SEPARATOR;
        foreach ($files as $file_name => $locales) {

            foreach ($locales[0] as $lang => $trans) {
                $path = resource_path('lang' . $slash . $lang . $slash . $file_name . '.php');
                $dir  = resource_path('lang' . $slash . $lang);

                if (is_array(trans($file_name, [], $lang))) {
                    $current_trans = array_dot(trans($file_name, [], $lang));
                    $trans         = array_merge($current_trans, $trans[0]);

                    foreach ($trans as $key => $value) {
                        $value = str_replace('"', "'", $value);
                        array_set($array, $key, $value);
                    }
                    if (!is_dir($dir)) {
                        File::makeDirectory($dir);
                    }

                    File::delete($path);
                    $trans_file = view('trans::excel.trans', compact('array'))->render();
                    File::put($path, $trans_file);
                    unset($array);
                }
            }
        }
    }



    /**
     * check the module name and selected locale is real or no
     *
     * @param array $modules
     * @param array $locales
     *
     * @return bool
     */
    public function isNotValidExcelSheet($modules, $locales)
    {
        $all_modules        = (array)module()->list(true);
        $all_active_locales = setting('site_locales')->gain();
        $modules_in_excel   = array_keys($modules);
        $i                  = 0;

        array_push($all_modules, 'overall');
        foreach ($modules_in_excel as $modules_name) {
            if (!in_array($modules_name, $all_modules)) {
                $i++;
            }
        }
        foreach ($locales as $locale) {
            if (!in_array($locale, $all_active_locales)) {
                $i++;
            }
        }

        return ($i >= 1) ? true : false;
    }



    /**
     * return count array depth
     *
     * @param array $array
     *
     * @return int
     */
    public function countArrayDepth(array $array)
    {
        $max_depth = 1;

        foreach ($array as $value) {
            if (is_array($value)) {
                $depth = $this->countArrayDepth($value) + 1;

                if ($depth > $max_depth) {
                    $max_depth = $depth;
                }
            }
        }

        return $max_depth;
    }



    /**
     * purify excel data in modules or overall
     *
     * @param array $result
     *
     * @return array
     */
    public function purifyExcelResult($result)
    {
        $data    = [];
        $locales = [];

        if ($this->countArrayDepth($result->toArray()) === 3) {
            foreach ($result as $sheet) {
                $module_name = $sheet->getTitle();
                array_push($locales, $sheet->getHeading());
                $data[$module_name] = $sheet;
            }
        } else {
            $module_name        = $result->getTitle();
            $locales            = $result->getHeading();
            $data[$module_name] = $result;
        }
        $locales         = array_unique(array_flatten($locales));
        $data['modules'] = $data;
        $data['locales'] = array_diff($locales, ['key']);

        return $data;
    }

}
