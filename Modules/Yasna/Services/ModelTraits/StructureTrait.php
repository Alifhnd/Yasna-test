<?php namespace Modules\Yasna\Services\ModelTraits;

use Illuminate\Support\Facades\Schema;

trait StructureTrait
{
    /**
     * get the reflector instance
     *
     * @return \ReflectionClass
     */
    public static function reflector()
    {
        return new \ReflectionClass(static::class);
    }



    /**
     * get the class name, without namespace (dynamic mode)
     *
     * @deprecated since 97/7/29.
     * @return string
     */
    public function getName()
    {
        return $this->getClassName();
    }



    /**
     * get the class name, without namespace (dynamic mode)
     *
     * @return string
     */
    public function getClassName()
    {
        return static::className();
    }



    /**
     * get the class name, without namespace (static mode)
     *
     * @return string
     */
    public static function className()
    {
        return static::reflector()->getShortName();
    }



    /**
     * get an array of the class methods
     *
     * @param string $pattern
     *
     * @return array
     */
    public function methodsArray($pattern = null)
    {
        $array = get_class_methods($this);

        if ($pattern) {
            $array = array_where($array, function ($value, $key) use ($pattern) {
                return str_contains($value, $pattern);
            });
        }


        return $array;
    }



    /**
     * @param $field_name
     *
     * @return bool
     */
    public function hasField($field_name)
    {
        return in_array($field_name, $this->fields_array);
    }



    /**
     * @param $field_name
     *
     * @return bool
     */
    public function hasnotField($field_name)
    {
        return !$this->hasField($field_name);
    }



    /**
     * @return bool
     */
    public function hasTrashSystem()
    {
        return method_exists($this, 'trashed');
    }



    /**
     * @return bool
     */
    public function hasnotTrashSystem()
    {
        return !$this->hasTrashSystem();
    }



    /**
     * get the fields array
     *
     * @return array
     */
    public function fieldList()
    {
        return $this->fields_array;
    }



    /**
     * @return string
     */
    public function moduleName()
    {
        $name  = get_parent_class($this);
        $array = explode("\\", $name);

        if (array_first($array) == 'Modules') {
            return $array[1];
        }

        return null;
    }



    /**
     * @return \Modules\Yasna\Services\ModuleHelper
     */
    public function module()
    {
        return module($this->moduleName());
    }



    /**
     * @return string
     */
    public function moduleAlias()
    {
        return $this->module()->getAlias();
    }



    /**
     * @param $method_name
     *
     * @return bool
     */
    protected function hasMethod($method_name)
    {
        return method_exists($this, $method_name);
    }



    /**
     * @param $method_name
     *
     * @return bool
     */
    protected function hasNotMethod($method_name)
    {
        return !$this->hasMethod($method_name);
    }



    /**
     * @return \Modules\Yasna\Services\YasnaModel
     */
    protected static function model()
    {
        return model(static::className());
    }
}
