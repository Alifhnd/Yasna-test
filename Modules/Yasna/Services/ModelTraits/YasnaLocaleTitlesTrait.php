<?php

namespace Modules\Yasna\Services\ModelTraits;

/**
 * This trait can be optionally used in the YasnaModel children to bring multilingual title functionality
 * @method  string|array getMeta(string $key)
 *
 * @package Modules\Yasna\Services\YasnaModel
 */
trait YasnaLocaleTitlesTrait
{
    /**
     * get the array of titles
     *
     * @return array
     */
    public function getTitlesArray()
    {
        return (array)$this->getMeta($this->getTitlesMetaName());
    }



    /**
     * get the title in the specified language
     *
     * @param string $locale
     *
     * @return null|string
     */
    public function titleIn(string $locale)
    {
        $titles = $this->getTitlesArray();

        if (isset($titles[$locale])) {
            return $titles[$locale];
        }

        return null;
    }



    /**
     * get the title in the current language
     *
     * @return null|string
     */
    public function getTitleInCurrentLocale()
    {
        return $this->titleIn(getLocale());
    }



    /**
     * get the title in the first available language, preferably the current language
     *
     * @return null|string
     */
    public function getFirstAvailableTitle()
    {
        $title = $this->getTitleInCurrentLocale();

        if ($title) {
            return $title;
        }

        return array_first($this->getTitlesArray());
    }



    /**
     * get the title in the current language
     *
     * @return null|string
     */
    public function getTitleAttribute()
    {
        return $this->getFirstAvailableTitle();
    }



    /**
     * get the required meta field to handle titles
     *
     * @return array
     */
    protected function titlesMetaFields()
    {
        return [
             $this->getTitlesMetaName(),
        ];
    }



    /**
     * get titles meta name
     *
     * @return string
     */
    protected function getTitlesMetaName()
    {
        return isset(static::$titles_meta_field_name) ? static::$titles_meta_field_name : "titles";
    }
}
