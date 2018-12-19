<?php
/**
 * Created by PhpStorm.
 * User: parsa
 * Date: 7/7/18
 * Time: 12:04 PM
 */

namespace Modules\Trans\services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class DynamicTrans
{
    private $key_without_dynamic;
    private $key_plain;
    private $locale;
    private $exists_trans = false;
    private $trans_object = null;
    const CACHE_TIME = 60 * 24;



    /**
     * DynamicTrans constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->locale              = App::getLocale();
        $this->key_plain           = trim($key);
        $this->key_without_dynamic = str_replace("dynamic.", "", trim($key));
    }



    /**
     * get value from dynamic trans
     *
     * @return string
     */
    public function getValue()
    {
        if ($this->hasCach()) {
            return $this->readFromCach();
        }
        $this->tryToFind();
        if (!$this->exists_trans) {
            $this->setCache($this->key_plain);
            return $this->key_plain;
        }
        $this->setCache($this->trans_object->value);
        return $this->trans_object->value;
    }



    /**
     * try to find trans with this key
     *
     * @return bool
     */
    private function tryToFind()
    {
        //with dynamic pattern
        $query = model('trans')
             ->where('slug', $this->key_without_dynamic)
             ->where('locale', $this->locale)
        ;
        if ($query->exists()) {
            $this->exists_trans = true;
            $this->trans_object = $query->first();
            return true;
        }

        //without dynamic pattern
        $query = model('trans')
             ->where('slug', $this->key_plain)
             ->where('locale', $this->locale)
        ;
        if ($query->exists()) {
            $this->exists_trans = true;
            $this->trans_object = $query->first();
            return true;
        }
        return false;
    }



    /**
     * check that this key has cache
     *
     * @return bool
     */
    private function hasCach()
    {
        return Cache::has("$this->key_without_dynamic.$this->locale");
    }



    /**
     * get value of trans from cache
     *
     * @return string
     */
    private function readFromCach()
    {
        return Cache::get("$this->key_without_dynamic.$this->locale");
    }



    /**
     * set cache for this key
     *
     * @param $value
     */
    private function setCache($value)
    {
        Cache::set("$this->key_without_dynamic.$this->locale", $value, self::CACHE_TIME);
    }
}
