<?php namespace Modules\Yasna\Entities\Traits;

/**
 * These methods are designed to be attached at the end of chain methods.
 * Class SettingHookTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property $desired_language
 * @property $default_value
 * @property $custom_value
 * @method purify($value)
 */
trait SettingGetTrait
{


    /**
     * @return bool
     */
    public function isDefined()
    {
        return $this->exists;
    }



    /**
     * @return bool
     */
    public function isNotDefined()
    {
        return !$this->isDefined();
    }



    /**
     * @return mixed
     */
    public function gain()
    {
        return $this->customValue();
    }



    /**
     * @return mixed
     */
    public function defaultValue()
    {
        return $this->purify($this->default_value);
    }



    /**
     * @return mixed
     */
    public function customValue()
    {
        $custom_value = $this->getCustomValueDependingOnLanguage();
        if (!isset($custom_value)) {
            return $this->defaultValue();
        }

        return $this->purify($custom_value);
    }



    /**
     * @return mixed
     */
    private function getCustomValueDependingOnLanguage()
    {

        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->isNotLocalized()) {
            return $this->custom_value;
        }


        /*-----------------------------------------------
        | Process ...
        */
        $array = $this->customValueToArray();

        if (isset($array[$this->desiredLanguage()])) {
            return $array[$this->desiredLanguage()];
        }

        return null;
    }



    /**
     * @return array
     */
    private function customValueToArray()
    {
        if (!is_json($this->custom_value)) {
            return [];
        }

        return json_decode($this->custom_value, true);
    }
}
