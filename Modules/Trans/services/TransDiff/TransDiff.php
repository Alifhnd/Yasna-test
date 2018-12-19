<?php

namespace Modules\Trans\services\TransDiff;


class TransDiff
{
    use TransModuleTrait, TransOverallTrait;


    public $all_modules = [];
    public $all_locales = [];



    /**
     * TransDiff constructor.
     */
    public function __construct()
    {
        $this->setAllModule();
        $this->setSiteLocales();
    }



    /**
     * Set property all_modules
     */
    public function setAllModule()
    {
        $this->all_modules = (array)module()->list();
    }



    /**
     * Set property site_locales
     */
    public function setSiteLocales()
    {
        $this->all_locales = setting('site_locales')->gain();
    }



    /**
     * get module with all keys fom any lang
     * example: Yasna =>['key1','key2']
     *
     * @param string|array $modules
     *
     * @return array
     */
    public function getModulesAllKeysTogether($modules)
    {

        $data = [];
        if (in_array('overall', $modules)) {
            $data['overall'] = $this->getAllKeys();
            $modules         = array_diff($modules, ['overall']);
        }

        if (is_array($modules)) {
            foreach ($modules as $module_name) {
                if ($this->moduleIsActive($module_name)) {
                    $data[$module_name] = $this->getModuleAllTransKeys(strtolower($module_name));
                }
            }
        } else {
            $module_name = $modules;
            if ($this->moduleIsActive($module_name)) {
                $data[$module_name] = $this->getModuleAllTransKeys(strtolower($module_name));
            }
        }

        return $data;
    }



    /**
     * get module with locale and keys
     *
     * @param string|array $modules
     *
     * @return array
     */
    public function getModulesTrans($modules)
    {
        $data = [];

        if (is_array($modules)) {
            foreach ($modules as $module_name) {
                if ($this->moduleIsActive($module_name)) {
                    $data[$module_name] = $this->getModuleAllTransKeysOnLang(strtolower($module_name));
                }
            }
        } else {
            $module_name = $modules;
            if ($this->moduleIsActive($module_name)) {
                $data[$module_name] = $this->getModuleAllTransKeysOnLang(strtolower($module_name));
            }
        }

        return $data;
    }


}
