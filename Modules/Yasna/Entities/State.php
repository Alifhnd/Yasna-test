<?php

namespace Modules\Yasna\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Yasna\Entities\Traits\StateCompatibilityTrait;
use Modules\Yasna\Entities\Traits\StateDomainsTrait;
use Modules\Yasna\Entities\Traits\StateHelpersTrait;
use Modules\Yasna\Entities\Traits\StateInterRelationsTrait;
use Modules\Yasna\Entities\Traits\StateIsTrait;
use Modules\Yasna\Services\YasnaModel;

class State extends YasnaModel
{
    use SoftDeletes;

    use StateInterRelationsTrait;
    use StateDomainsTrait;
    use StateIsTrait;
    use StateHelpersTrait;
    use StateCompatibilityTrait;
    protected $casts = [
         'meta' => "array",
    ];



    /**
     * Works on Demand
     */
    public function forgetCaches()
    {
        cache()->forget('states-combo');
    }



    /**
     * get latitude value from meta field
     *
     * @return string|null
     */
    public function getLatitudeAttribute()
    {
        return $this->meta['latitude'] ?? null;
    }



    /**
     * get weather value from meta field
     *
     * @return string|null
     */
    public function getLongitudeAttribute()
    {
        return $this->meta['longitude'] ?? null;
    }



    /**
     * get weather value from meta field
     *
     * @return string|null
     */
    public function getWeatherAttribute()
    {
        return $this->meta['weather'] ?? null;
    }



    /**
     * @return array
     */
    public function mainMetaFields()
    {
        return [
             'latitude',
             'longitude',
             'weather',
        ];
    }

}
