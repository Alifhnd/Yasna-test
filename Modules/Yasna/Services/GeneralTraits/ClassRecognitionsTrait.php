<?php

namespace Modules\Yasna\Services\GeneralTraits;

/**
 * add class recognition capabilities to the serializable classes
 *
 * @TODO: add Wiki link
 */
trait ClassRecognitionsTrait
{
    /**
     * get the called class name, fully qualified
     *
     * @return string
     */
    public static function calledClass()
    {
        return get_called_class();
    }



    /**
     * get the called class name, without namespace or anything extra
     *
     * @return string
     */
    public static function calledClassName()
    {
        return array_last(explode("\\", static::calledClass()));
    }

}
