<?php

namespace Modules\Yasna\Services\GeneralTraits;

/**
 * add serializing capabilities to the serializable classes
 *
 * @TODO: add Wiki link
 */
trait Serializable
{
    /**
     * serialize and encrypt the instance into a single string
     *
     * @return string
     */
    public function serialize()
    {
        return encrypt(serialize($this));
    }



    /**
     * get the md5 signature of the serialized class
     *
     * @return string
     */
    public function md5()
    {
        return md5(serialize($this));
    }



    /**
     * get the original instance from the encrypted serialized string
     *
     * @TODO for the future: add safety checks before action
     *
     * @param string $serialized
     *
     * @return mixed
     */
    public static function unserialize($serialized)
    {
        return unserialize(decrypt($serialized));
    }

}
