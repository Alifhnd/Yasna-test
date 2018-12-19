<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Yasna\Entities\State;

/**
 * Class StateInterRelationsTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property int $id
 * @property int $parent_id
 * @property int $capital_id
 * @method Builder where($field_name, $operator = '', $value = '')
 * @method $this grab(int $id, string $field_name = '')
 */
trait StateInterRelationsTrait
{
    /**
     * Returns the province of a city, supporting accidental call from a province.
     *
     * @return State|$this
     */
    public function province()
    {
        if ($this->isProvince()) {
            return $this;
        }

        return $this->grab($this->parent_id);
    }



    /**
     * @return $this|State
     */
    public function getProvinceAttribute()
    {
        return $this->province();
    }



    /**
     * Returns cities of a province, supporting accidental call from a city.
     *
     * @return Builder
     */
    public function cities()
    {
        if (!$this->id) {
            return $this->allCities();
        }

        if ($this->isCity()) {
            return $this->provincialCities();
        }

        return $this->where('parent_id', $this->id);
    }



    /**
     * @return Builder
     */
    public function allCities()
    {
        return $this->where('parent_id', '>', 0);
    }



    /**
     * @return Builder
     */
    public function allProvinces()
    {
        return $this->where('parent_id', 0);
    }



    /**
     * Returns cities of same province, supporting accidental call from a province.
     *
     * @return Builder
     */
    public function provincialCities()
    {
        if ($this->isProvince()) {
            return $this->cities();
        }
        return $this->where('parent_id', $this->parent_id);
    }



    /**
     * Returns the capital city, supporting accidental call from a city.
     *
     * @return State
     */
    public function capitalCity()
    {
        if ($this->isCity()) {
            return $this->province()->capitalCity();
        }

        return $this->newInstance()->grab($this->capital_id);
    }



    /**
     * A mirror to $this->getCapitalCity(), for compatibility purpose.
     *
     * @return State
     * @deprecated
     */
    public function capital()
    {
        return $this->capitalCity();
    }



    /**
     * @return State
     * @deprecated
     */
    public function getCapitalAttribute()
    {
        return $this->capitalCity();
    }



    /**
     * @return State
     */
    public function getCapitalCityAttribute()
    {
        return $this->capitalCity();
    }
}
