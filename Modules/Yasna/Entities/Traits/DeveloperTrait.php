<?php namespace Modules\Yasna\Entities\Traits;

trait DeveloperTrait
{
    /**
     * @return bool
     */
    public function markAsDeveloper()
    {
        $setting = setting('app_key');

        if ($setting->isNotDefined()) {
            return $this->makeSettingRow();
        }

        return setting('app_key')->setValue(encrypt($this->id));
    }



    /**
     * @return bool
     */
    public function removeDeveloper()
    {
        return setting('app_key')->hardDelete();
    }



    /**
     * @return bool
     */
    public function makeSettingRow()
    {
        return setting()->new([
             "slug"          => "app_key",
             "title"         => trans_safe("yasna::seeders.app_key"),
             "category"      => "upstream",
             "order"         => "6",
             "data_type"     => "text",
             "default_value" => encrypt($this->id),
        ]);
    }



    /**
     * @return bool
     */
    public function isDeveloper()
    {
        return boolval($this->id == $this->getDeveloperId());
    }



    /**
     * @return bool
     */
    public function isNotDeveloper()
    {
        return !$this->isDeveloper();
    }



    /**
     * @return \Modules\Yasna\Entities\User
     */
    public function findDeveloper()
    {
        return user($this->getDeveloperId());
    }



    /**
     * @return bool|string
     */
    public function getDeveloperId($no_cache = false)
    {
        $setting = setting('app_key')->noCache($no_cache);

        if ($setting->isNotDefined()) {
            return false;
        } else {
            return safeDecrypt($setting->gain(), 0);
        }
    }
}
