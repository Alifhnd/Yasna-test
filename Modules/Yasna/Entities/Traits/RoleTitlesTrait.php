<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait RoleTitlesTrait, attached to Role
 *
 * @property string $title
 * @property string $plural_title
 */
trait RoleTitlesTrait
{
    /**
     * get title in a specified language.
     *
     * @param string $locale
     *
     * @return string
     */
    public function titleIn($locale = 'fa'): string
    {
        if ($locale == 'fa') {
            return $this->title;
        }

        return $this->getMeta("locale_titles")["title-$locale"];
    }



    /**
     * get plural title in a specified language.
     *
     * @param string $locale
     *
     * @return string
     */
    public function pluralTitleIn($locale): string
    {
        if ($locale == 'fa') {
            return $this->plural_title;
        }

        return $this->getMeta("locale_titles")["plural_title-$locale"];
    }
}
