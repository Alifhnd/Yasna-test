<?php namespace Modules\Yasna\Services\ModuleTraits;

use Modules\Yasna\Services\YasnaController;

trait MagicTrait
{
    private $magic_name;
    private $magic_arguments;



    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $this->magic_name      = $name;
        $this->magic_arguments = $arguments;

        if (str_contains($name, 'Controller')) {
            return $this->executeController();
        }

        return false;
    }



    /**
     * @return YasnaController
     */
    private function executeController()
    {
        return $this->getController(studly_case($this->magic_name));
    }
}
