<?php namespace Modules\Yasna\Entities\Traits;

/**
 * Class StateIsTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property int $parent_id
 */
trait StateIsTrait
{
    /**
     * @return bool
     */
    public function isProvince()
    {
        return !boolval($this->parent_id);
    }



    /**
     * @return bool
     */
    public function isNotProvince()
    {
        return !$this->isProvince();
    }



    /**
     * @return bool
     */
    public function isCity()
    {
        return boolval($this->parent_id);
    }



    /**
     * @return bool
     */
    public function isNotCity()
    {
        return !$this->isCity();
    }



    /**
     * @return bool
     */
    public function isCapitalCity()
    {
        if ($this->isProvince()) {
            return false;
        }

        return boolval($this->province()->capital_id == $this->id);
    }



    /**
     * @return bool
     * @deprecated
     */
    public function isCapital()
    {
        return $this->isCapitalCity();
    }



    /**
     * @return bool
     */
    public function isNotCapitalCity()
    {
        return !$this->isCapitalCity();
    }
}
