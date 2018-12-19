<?php namespace Modules\Yasna\Services\ModelTraits;

/**
 * @property int $id
 */
trait ExistenceTrait
{
    /**
     * @return bool
     */
    public function isset()
    {
        return boolval($this->id);
    }



    /**
     * @return bool
     */
    public function isNotSet()
    {
        return !$this->isset();
    }



    /**
     * @return bool
     */
    public function getNotExistsAttribute()
    {
        return !boolval($this->exists);
    }
}
