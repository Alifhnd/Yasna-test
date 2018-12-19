<?php
namespace Modules\Yasna\Services\Responders;

use Illuminate\Support\Facades\Lang;
use Symfony\Component\Debug\Exception\UndefinedFunctionException;

class ApiResponseAbstract
{
    protected static $standard = "white-house";
    protected static $module_name;



    /**
     * magic method
     *
     * @param string $method_name
     * @param mixed  $arguments
     *
     * @return $this|mixed
     * @throws UndefinedFunctionException
     */
    public function __call($method_name, $arguments)
    {
        if (str_contains($method_name, 'get')) {
            return $this->getter(str_after($method_name, 'get'));
        }

        if (str_contains($method_name, 'with')) {
            $this->setter(str_after($method_name, 'with'), $arguments[0]);
            return $this;
        }

        throw new UndefinedFunctionException("Unsupported magic call!", previousException());
    }



    /**
     * get property
     *
     * @param string $property_name
     *
     * @return mixed
     */
    private function getter($property_name)
    {
        $property_name = snake_case($property_name);

        if (isset($this->$property_name)) {
            return $this->$property_name;
        }

        return null;
    }



    /**
     * set property
     *
     * @param string $property_name
     * @param mixed  $value
     */
    private function setter($property_name, $value)
    {
        $property_name = snake_case($property_name);

        $this->$property_name = $value;
    }



    /**
     * @inheritdoc
     */
    public static function setStandard($standard)
    {
        static::$standard = $standard;
    }



    /**
     * @inheritdoc
     */
    public static function getStandard()
    {
        return static::$standard;
    }



    /**
     * @inheritdoc
     */
    public static function setModuleName($module_name)
    {
        static::$module_name = $module_name;
    }



    /**
     * @inheritdoc
     */
    public function inModule($module_name)
    {
        static::setModuleName($module_name);
        return $this;
    }



    /**
     * @inheritdoc
     */
    public static function getModuleName()
    {
        $module = module(static::$module_name);

        if ($module->isValid()) {
            return module(static::$module_name)->getName();
        }

        return null;
    }



    /**
     * @inheritdoc
     */
    public function getModuleAlias()
    {
        $module = module(static::$module_name);

        if ($module->isValid()) {
            return module(static::$module_name)->getAlias();
        }

        return null;
    }



    /**
     * initialize the object
     *
     * @param string $standard
     *
     * @return ApiResponseInterface
     */
    public static function init($standard = null)
    {
        if ($standard) {
            static::setStandard($standard);
        }

        $name_space = 'Modules\Yasna\Services\Responders\Standards\\';
        $class_name = studly_case("api-" . static::$standard . "-response");
        $class      = $name_space . $class_name;

        return new $class;
    }



    /**
     * return the corresponding trans of an error code
     *
     * @param string     $file_name
     * @param string|int $code
     *
     * @return string string
     */
    protected function trans($file_name, $code)
    {
        $alias = self::getModuleAlias();
        $map1  = "$alias::$file_name.$code";

        $tried1 = yasna()::transRecursive($map1);
        if ($tried1 != $map1) {
            return $tried1;
        }

        $map2   = "$alias::$file_name.default";
        $tried2 = yasna()::transRecursive($map2);
        if ($tried2 != $map2) {
            return $tried2;
        }

        if (debugMode()) {
            return $map1;
        }

        return '';
    }
}
