<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/28/18
 * Time: 12:33 PM
 */

namespace Modules\Yasna\Services\ModelTraits;

/**
 * Trait UniqueUrlTrait
 * This trait can be used in any model.
 * Methods in this trait work on the unique URL of any entity.
 * <br>
 * For each model setting should exist to hold the pattern of the unique URL.
 * The slug of the setting will be returned by the `getUniqueUrlPatternSlug()` method.
 */
trait UniqueUrlTrait
{
    /**
     * Returns the unique sub URL of the entity based on the related setting's value in current site locale.
     *
     * @return mixed|null|string
     */
    public function getUniqueSubUrl()
    {
        return $this->getUniqueSubUrlIn(getLocale());
    }



    /**
     * Returns the unique sub URL in the specified locale.
     *
     * @param string $locale
     *
     * @return mixed|null|string
     */
    public function getUniqueSubUrlIn(string $locale)
    {
        $pattern = $this->getUniqueUrlPattern($locale);
        if (!$pattern) {
            return null;
        }

        return $this->fillUrlPattern($pattern);
    }



    /**
     * Accessor for the `getUniqueSubUrl()` Method
     *
     * @return mixed|null|string
     */
    public function getUniqueSubUrlAttribute()
    {
        return $this->getUniqueSubUrl();
    }



    /**
     * Returns the unique URL of the entity based on the related setting's value in current site locale.
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getUniqueUrl()
    {
        return $this->getUniqueUrlIn(getLocale());
    }



    /**
     * Returns the unique URL in the specified locale.
     *
     * @param string $locale
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|null|string
     */
    public function getUniqueUrlIn(string $locale)
    {
        $sub_url = $this->getUniqueSubUrlIn($locale);
        return $sub_url ? url($sub_url) : $sub_url;
    }



    /**
     * Accessor for the `getUniqueUrl()` Method
     *
     * @return \Illuminate\Contracts\Routing\UrlGenerator|null|string
     */
    public function getUniqueUrlAttribute()
    {
        return $this->getUniqueUrl();
    }



    /**
     * Reads the pattern of the unique URL in the given locale and returns it.
     *
     * @param string $locale
     *
     * @return null|string
     */
    protected function getUniqueUrlPattern(string $locale)
    {
        return setting($this->getUniqueUrlPatternSlug())
             ->in($locale)
             ->gain()
             ;
    }



    /**
     * Returns the slug of the unique URL's pattern based on this model.
     *
     * @return string
     */
    public static function getUniqueUrlPatternSlug()
    {
        $class_name = static::className();
        return snake_case($class_name . '_unique_url');
    }



    /**
     * Replaces the needed attributes in the given pattern and returns the result.
     * <br>
     * _Any string between two curly brackets will be assumed as an attribute and filled with the attribute of the
     * model_
     *
     * @param string $pattern
     *
     * @return mixed|string
     */
    protected function fillUrlPattern(string $pattern)
    {
        $url = $pattern;

        // Extract parameters
        preg_match_all('/\{([^}]+)\}/', $pattern, $matches);
        $parameters = ($matches[1] ?? []);

        // Replace parameters
        foreach ($parameters as $parameter) {
            $attribute = $this->$parameter;
            if (!$attribute) {
                continue;
            }
            $url = str_replace('{' . $parameter . '}', $attribute, $url);
        }

        return $url;
    }
}
