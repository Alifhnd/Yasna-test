<?php namespace Modules\Yasna\Services\ModuleTraits;

/**
 * can be used on any class inside modules to retreive the information about the current running module
 *
 * @package Modules\Yasna\Services\ModuleTraits
 */
trait ModuleRecognitionsTrait
{
    private $running_module;



    /**
     * @return \Modules\Yasna\Services\ModuleHelper
     */
    protected function runningModule()
    {
        return module($this->runningModuleName());
    }



    /**
     * @return string
     */
    protected function runningModuleName()
    {
        $name  = get_class($this);
        $array = explode("\\", $name);

        if (array_first($array) == 'Modules') {
            return $array[1];
        }

        return null;
    }



    /**
     * @return string
     */
    protected function runningModuleAlias()
    {
        return $this->runningModule()->getAlias();
    }
}
