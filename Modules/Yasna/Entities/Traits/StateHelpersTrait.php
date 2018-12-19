<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class StateHelpersTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property string $title
 */
trait StateHelpersTrait
{


    /**
     * @return string
     */
    public function fullName()
    {
        if (!$this->exists) {
            return null;
        }
        if ($this->isProvince()) {
            return trans('yasna::states.province') . "  " . $this->title;
        }

        return $this->province()->title . " / " . $this->title;
    }



    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->fullName();
    }



    /**
     * @param string $title
     *
     * @return $this
     */
    public function findByTitle(string $title)
    {
        return $this->grab($title, 'title');
    }



    /**
     * Returns cities of a certain province, given either by id or title
     *
     * @param int|string $province_id_or_title
     *
     * @return Builder
     */
    public function citiesOf($province_id_or_title)
    {
        if (is_string($province_id_or_title)) {
            return static::model()->findByTitle($province_id_or_title)->cities();
        }

        if ($province_id_or_title == 0) {
            return static::model()->allCities();
        }

        return static::model()->grab($province_id_or_title)->cities();
    }



    /**
     * @param bool $force_fresh
     *
     * @return array
     */
    public function combo($force_fresh = false)
    {
        $cache_key  = 'states-combo';
        $cache_time = 1000;

        if (cache()->has($cache_key) and !$force_fresh) {
            return cache()->get($cache_key);
        }

        cache()->put($cache_key, $combo_array = $this->comboQuery(), $cache_time);
        return $combo_array;
    }



    /**
     * @return array
     */
    private function comboQuery()
    {
        $result    = [];
        $provinces = $this->allProvinces()->orderBy('title')->get();
        $cities    = $this->allCities()->orderBy('title')->get();

        foreach ($provinces as $province) {
            foreach ($cities->where('parent_id', $province->id) as $city) {
                $result[] = [
                     $city->id,
                     $city->full_name,
                ];
            }
        }

        return $result;
    }



    /**
     * @return bool
     */
    public function setAsCapital()
    {
        if ($this->isProvince()) {
            return false;
        }

        $update_array = [
             "capital_id" => $this->id,
        ];

        return $this->province()->update($update_array);
    }
}
