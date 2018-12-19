<?php namespace Modules\Yasna\Entities\Traits;

/**
 * Class SettingSetTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property $desired_language
 */
trait SettingSetTrait
{
    /**
     * Sets custom value to the already defined models.
     *
     * @param $new_value
     *
     * @return bool
     */
    public function setCustomValue($new_value)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->isNotDefined()) {
            return false;
        }

        /*-----------------------------------------------
        | Process ...
        */
        if ($this->isLocalized()) {
            $array                           = $this->customValueToArray();
            $array[$this->desiredLanguage()] = $new_value;
            $new_value                       = json_encode($array);
        }

        $this->forgetMyCache();

        return $this->batchSaveBoolean([
             "custom_value" => $new_value,
        ]);
    }



    /**
     * @param $new_value
     *
     * @return bool
     */
    public function setValue($new_value)
    {
        return $this->setCustomValue($new_value);
    }



    /**
     * Sets default value to the already defined models.
     *
     * @param $new_value
     *
     * @return bool
     */
    public function setDefaultValue($new_value)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->isNotDefined()) {
            return false;
        }

        /*-----------------------------------------------
        | Process ...
        */
        $this->forgetMyCache();
        return $this->batchSaveBoolean([
             "default_value" => $new_value,
        ]);
    }



    /**
     * Inserts new record in settings table
     *
     * @param $data
     */
    public function new($data)
    {
        $data = array_normalize($data, [
             "slug"          => "",
             "title"         => "",
             "order"         => "21",
             "category"      => "upstream",
             "data_type"     => "text",
             "default_value" => "",
             "hint"          => "",
             "is_localized"  => false,
        ]);

        yasna()->seed('settings', [$data]);
        $return = setting($data['slug'])->noCache()->isDefined();

        return $return;
    }



    /**
     * @param      $slug
     * @param      $new_value
     * @param bool $locale
     * @param bool $set_for_default
     *
     * @return bool
     * @deprecated
     */
    public static function set($slug, $new_value, $locale = false, $set_for_default = false)
    {
        if ($set_for_default) {
            return setting($slug)->setDefaultValue($new_value);
        }

        return setting($slug)->in($locale)->setValue($new_value);
    }
}
