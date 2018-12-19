<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class StateCompatibilityTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @method $this model()
 */
trait StateCompatibilityTrait
{
    /**
     * @return Builder
     * @deprecated
     */
    public static function getProvinces()
    {
        return static::model()->allProvinces();
    }



    /**
     * @param int|string $given_province
     *
     * @return Builder
     * @deprecated
     */
    public static function getCities($given_province = 0)
    {
        return static::model()->citiesOf($given_province);
    }



    /**
     * @param string $state_name
     *
     * @return mixed
     * @deprecated
     */
    public static function findByName($state_name)
    {
        return static::model()->findByTitle($state_name);
    }



    /**
     * Sets a given city, the capital of a given province. It's a bullshit thing, indeed.
     *
     * @param $province_name
     * @param $city_name
     *
     * @deprecated
     */
    public static function setCapital($province_name, $city_name)
    {
        if (!$city_name) {
            $city_name = $province_name;
        }
        $province = self::where([
             'title'     => $province_name,
             'parent_id' => '0',
        ])->first()
        ;
        $city     = self::where([
             ['title', $city_name],
             ['parent_id', '!=', '0'],
        ])->first()
        ;

        $province->capital_id = $city->id;
        $province->save();
    }
}
