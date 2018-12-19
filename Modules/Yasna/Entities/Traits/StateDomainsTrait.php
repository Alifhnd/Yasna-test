<?php namespace Modules\Yasna\Entities\Traits;

trait StateDomainsTrait
{
    /**
     * Conventional Relationship Method
     *
     * @return mixed
     */
    public function domain()
    {
        return $this->belongsTo(MODELS_NAMESPACE . 'Domain');
    }



    /**
     * @return int
     */
    public function getGuessDomainAttribute()
    {
        return $this->guessDomain();
    }



    /**
     * @return int
     */
    public function guessDomain()
    {
        if ($found = $this->guessDomainByCheckingProvincialCities()) {
            return $found;
        }

        return 0;
    }



    /**
     * @return int
     */
    private function guessDomainByCheckingProvincialCities()
    {
        $a_city = $this->provincialCities()->where('domain_id', '>', 0)->first();

        if ($a_city) {
            return $a_city->domain_id;
        }

        return 0;
    }
}
