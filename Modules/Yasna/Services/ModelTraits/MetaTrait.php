<?php
namespace Modules\Yasna\Services\ModelTraits;

trait MetaTrait
{
    protected $meta_array           = [];
    protected $meta_spread          = false;
    protected $meta_array_set       = false;
    private $cached_meta_list_set = false;
    private $cached_meta_list     = [];

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Returns a safe presentation of meta field, in the form of $this->meta.
     *
     * @param $original
     *
     * @return array
     */
    public function getMetaAttribute($original)
    {
        if (!$this->exists) {
            return $this->setMetaArray([]);
        }

        if (is_array($original)) {
            return $this->setMetaArray($original);
        } else {
            return $this->setMetaArray(json_decode($original, true));
        }
    }



    /**
     * List of meta fields, according to the arrays returned in any FolanMetaFields() withing the class.
     *
     * @return array
     */
    public function getMetaFields()
    {
        if ($this->cached_meta_list_set) {
            return $this->cached_meta_list;
        }
        $result = [];

        foreach ($this->methodsArray('MetaFields') as $method) {
            if ($method == 'getMetaFields') {
                continue;
            }
            $result = array_merge($result, $this->$method());
        }

        $this->setCachedMetaList($result);
        return $result;
    }



    /**
     * Sets cached meta fields, according to what is received as argument.
     *
     * @param $meta_fields_array
     */
    private function setCachedMetaList($meta_fields_array)
    {
        $this->cached_meta_list     = $meta_fields_array;
        $this->cached_meta_list_set = true;
    }



    /**
     * Unsets cached meta fields
     */
    private function unsetCachedMetaList()
    {
        $this->cached_meta_list_set = false;
    }



    /**
     * array of meta values, using the intermediate protected $this->meta_array property.
     *
     * @param bool $force_fresh
     *
     * @return array
     */
    public function getMetaArray($force_fresh = false)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem()) {
            return [];
        }

        /*-----------------------------------------------
        | On Not-Existing Models ...
        */
        if (!$this->exists) {
            return $this->meta_array;
        }

        /*-----------------------------------------------
        | On Existing Models,...
        */
        if ($this->meta_array_set and !$force_fresh) {
            return $this->meta_array;
        }

        return $this->meta;
    }



    /**
     * Gets a specific meta value
     *
     * @param null $slug
     *
     * @return array|null
     */
    public function getMeta($slug = null)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if (!$slug) {
            return $this->getMetaArray();
        }
        //if ($this->isNotMeta($slug)) {
        //    return null;
        //}
        /*-----------------------------------------------
        | Process ...
        */
        $data = $this->getMetaArray();

        if (isset($data[$slug])) {
            return $data[$slug];
        }

        return null;
    }



    /**
     * Loads $this->meta_array if not set already.
     */
    public function loadMetaArrayIfNotAlready()
    {
        if (!$this->meta_array_set) {
            $this->refreshMetaArray();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Safely, puts an array into the intermediate protected $this->meta_array property.
     *
     * @param $new_meta_array
     *
     * @return array
     */
    public function setMetaArray($new_meta_array)
    {
        if (!$new_meta_array or !is_array($new_meta_array)) {
            $new_meta_array = [];
        }

        //foreach ($new_meta_array as $key => $value) {
        //    if ($this->isNotMeta($key)) {
        //        unset($new_meta_array[$key]);
        //    }
        //}

        $this->meta_array_set = true;
        $this->meta_array     = $new_meta_array;

        return $new_meta_array;
    }



    /**
     * Adds something to the intermediate protected $this->meta_array property.
     *
     * @param $field
     * @param $value
     *
     * @return bool
     */
    public function addToMetaArray($field, $value)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem() or $this->isNotMeta($field)) {
            return false;
        }

        /*-----------------------------------------------
        | Process ...
        */
        $this->meta_array[$field] = $value;
        return true;
    }



    /**
     * Safely removes something from the intermediate protected $this->meta_array property.
     *
     * @param $field
     *
     * @return bool
     */
    public function removeFromMetaArray($field)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem() or $this->isNotMeta($field)) {
            return false;
        }
        if (!isset($this->meta_array[$field])) {
            return false;
        }

        /*-----------------------------------------------
        | Process ...
        */
        unset($this->meta_array[$field]);
        return true;
    }



    /**
     * Adds/Deletes information to/from intermediate protected $this->meta_array property.
     *
     * @param $field
     * @param $value
     *
     * @return bool
     */
    public function updateMetaArray($field, $value)
    {
        if ($value === false or $value == 'unset') {
            return $this->removeFromMetaArray($field);
        }

        return $this->addToMetaArray($field, $value);
    }



    /**
     * Sets a single item in the intermediate protected $this->meta_array property.
     *
     * @param $field
     * @param $value
     *
     * @return bool
     */
    public function setMeta($field, $value)
    {
        if ($this->isNotMeta($field)) {
            return false;
        }

        $this->loadMetaArrayIfNotAlready();
        return $this->updateMetaArray($field, $value);
    }



    /**
     * Sets an array of $field=>$value pairs to the intermediate protected $this->meta_array property.
     *
     * @param $array
     *
     * @return bool
     */
    public function setMetas($array)
    {
        foreach ($array as $field => $value) {
            $this->setMeta($field, $value);
        }

        return true;
    }



    /*
    |--------------------------------------------------------------------------
    | Inquiry
    |--------------------------------------------------------------------------
    |
    */


    /**
     * @return bool
     */
    public function hasMetaSystem()
    {
        return $this->hasField('meta');
    }



    /**
     * @return bool
     */
    public function hasnotMetaSystem()
    {
        return !$this->hasMetaSystem();
    }



    /**
     * Detects if the given $fields is a valid meta field.
     *
     * @param $field
     *
     * @return bool
     */
    public function isMeta($field)
    {
        return in_array($field, $this->getMetaFields());
    }



    /**
     * Reverse of the isMeta method
     *
     * @param $field
     *
     * @return bool
     */
    public function isNotMeta($field)
    {
        return !$this->isMeta($field);
    }



    /*
    |--------------------------------------------------------------------------
    | Process
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Refreshes the intermediate protected $this->meta_array property, by passing true to the $this->getMetaArray()
     * method.
     *
     * @return array
     */
    public function refreshMetaArray()
    {
        return $this->getMetaArray(true);
    }



    /**
     * Spreads meta values, alongside normal values.
     *
     * @param bool $force_fresh
     *
     * @return $this
     */
    public function spreadMeta($force_fresh = false)
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem()) {
            return $this;
        }
        if ($this->meta_spread and !$force_fresh) {
            return $this;
        }

        /*-----------------------------------------------
        | Process  ...
        */
        foreach ($this->getMetaArray($force_fresh) as $field => $value) {
            //if ($this->isMeta($field)) {
                $this->$field = $value;
            //}
        }
        $this->meta_spread = true;

        /*-----------------------------------------------
        | Return ...
        */
        return $this;
    }



    /**
     * Suppresses the spread meta values and puts the snake back in the box.
     *
     * @return $this
     */
    public function suppressMeta()
    {
        /*-----------------------------------------------
        | Bypass ...
        */
        if ($this->hasnotMetaSystem() or !$this->meta_spread) {
            return $this;
        }

        /*-----------------------------------------------
        | Browse ...
        */
        $data = $this->toArray();
        foreach ($data as $field => $value) {
            if ($this->hasnotField($field)) {
                unset($this->$field);
            }
        }
        $this->meta_spread = false;

        /*-----------------------------------------------
        | Return ...
        */
        return $this;
    }



    /**
     * An instance of the current object without meta values.
     *
     * @return $this
     */
    public function withoutMeta()
    {
        $instance = clone $this;
        return $instance->suppressMeta();
    }



    /**
     * Utilizes $this->setMeta() and $this->updateMeta() to update a single meta value in the database.
     *
     * @param $field
     * @param $value
     *
     * @return bool
     */
    public function updateOneMeta($field, $value)
    {
        $done = $this->setMeta($field, $value);

        if ($done and $this->exists) {
            return $done = $this->updateMeta();
        }

        return false;
    }



    /**
     * Utilizes $this->setMetas() and $this->updateMeta() to update the given [$field=>$value] array of metas in the
     * database.
     *
     * @param $array
     *
     * @return bool
     */
    public function updateSomeMeta($array)
    {
        $done = $this->setMetas($array);

        if ($done and $this->exists) {
            return $this->updateMeta();
        }

        return false;
    }



    /**
     * Safely runs the query to update the meta with the intermediate protected $this->meta_array property.
     *
     * @param null $new_meta to bypass $this->meta_array property.
     *
     * @return bool
     */
    public function updateMeta($new_meta = null)
    {
        if (!isset($new_meta)) {
            $new_meta = $this->getMetaArray();
        }

        if (!$this->hasCast('meta') or $this->getCastType('meta') != 'array') {
            $new_meta = json_encode($new_meta);
        }

        $ok = $this->withoutMeta()->update([
             'meta' => $new_meta,
        ])
        ;

        if ($ok) {
            $this->refresh();
        }

        return $ok;
    }



    /**
     * Safely updates the $this->meta with the intermediate protected $this->meta_array property, but without running
     * any sql query!
     *
     * @param null $new_meta
     *
     * @return array|null|string
     */
    public function UpdateMetaProperty($new_meta = null)
    {
        if (!isset($new_meta)) {
            $new_meta = $this->getMetaArray();
        }

        if (!$this->hasCast('meta') or $this->getCastType('meta') != 'array') {
            $new_meta = json_encode($new_meta);
        }

        return $this->meta = $new_meta;
    }
}
