<?php

namespace Modules\Yasna\Entities\Traits;

trait UserPreferencesTrait
{
    protected $default_preferences = [
         'max_rows_per_page' => 50,
    ];



    /**
     * @return array
     */
    public function preferencesMetaFields()
    {
        return [
             'preferences',
        ];
    }



    /**
     * @return string
     */
    public function getPreferencesAttribute()
    {
        return $this->preferences();
    }



    /**
     * @return string
     */
    public function preferences()
    {
        return $this->getMeta('preferences');
    }



    /**
     * @param      $key
     * @param null $default
     *
     * @return string
     */
    public function preference($key, $default = null)
    {
        $preference = $this->preferences();
        if (isset($preference[$key])) {
            return $this->preferences()[$key];
        } elseif (isset($this->default_preferences[$key])) {
            return $this->default_preferences[$key];
        } else {
            return $default;
        }
    }



    /**
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function setPreference($key, $value)
    {
        $preferences       = $this->preferences();
        $preferences[$key] = $value;
        return $this->updateMeta([
             'preferences' => $preferences,
        ], true);
    }



    /**
     * @return bool
     */
    public function resetPreferences()
    {
        return $this->updateMeta([
             'preferences' => null,
        ], true);
    }
}
