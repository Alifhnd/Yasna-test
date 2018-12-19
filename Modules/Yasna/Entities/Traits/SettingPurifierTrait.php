<?php namespace Modules\Yasna\Entities\Traits;

use Carbon\Carbon;

/**
 * Class SettingPurifierTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property $data_type
 */
trait SettingPurifierTrait
{
    private $without_purification = false;



    /**
     * @param $value
     *
     * @return mixed
     */
    protected function purify($value)
    {
        if ($this->without_purification) {
            return $value;
        }
        $value = $this->purifyWithDataType($value);

        return $value;
    }



    /**
     * @param $value
     *
     * @return mixed
     */
    private function purifyWithDataType($value)
    {
        $method_name = camel_case("make it " . $this->data_type);

        if ($this->hasMethod($method_name)) {
            return $this->$method_name($value);
        }

        return $value;
    }



    /**
     * @param $value
     *
     * @return array
     */
    protected function makeItArray($value)
    {
        $value = nl2br($value);
        $value = str_replace("\r","",$value);
        $value = str_replace("\n","",$value);

        return explode_not_empty("<br />", $value);
    }



    /**
     * @param $value
     *
     * @return bool
     */
    protected function makeItBoolean($value)
    {
        return boolval($value);
    }



    /**
     * @param $value
     *
     * @return string
     */
    protected function makeItDate($value)
    {
        $carbon = new Carbon($value);
        return $carbon->toDateTimeString();
    }
}
