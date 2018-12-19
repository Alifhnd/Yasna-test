<?php namespace Modules\Yasna\Entities\Traits;

trait DomainPostsTrait
{
    public function posts()
    {
        return $this->hasMany(MODELS_NAMESPACE . "Post");
    }
}
