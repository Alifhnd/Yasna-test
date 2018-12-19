<?php namespace Modules\Yasna\Entities\Traits;

use Modules\Manage\Http\Requests\SettingSetRequest;

/**
 * Class SettingPanelTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property $title
 * @property $category
 * @property $order
 * @property $hint
 * @property $css_class
 * @property $is_localized
 */
trait SettingPanelTrait
{
    private $reserved_slugs = ['none', 'setting'];



    /**
     * @return array
     */
    public function categoriesArray()
    {
        return ['template', 'contact', 'socials', 'database', 'users', 'security', 'upstream', 'invisible'];
    }



    /**
     * suitable validation request
     *
     * @return string
     */
    public function categoryList()
    {
        return implode(',', $this->categoriesArray());
    }



    /**
     * to be used in upstream edit panel
     *
     * @return array
     */
    public function categoriesCombo()
    {
        $return = [];

        foreach ($this->categoriesArray() as $item) {
            if ($item == 'upstream' and !dev()) {
                continue;
            }

            $return[] = [
                 $item,
                 trans_safe("manage::settings.categories.$item"),
            ];
        }

        return $return;
    }



    /**
     * @return array
     */
    public function dataTypesArray()
    {
        return ['text', 'textarea', 'boolean', 'date', 'photo', 'file', 'array'];
    }



    /**
     * suitable for validation request
     *
     * @return string
     */
    public function dataTypeList()
    {
        return implode(',', $this->dataTypesArray());
    }



    /**
     * @return array
     */
    public function dataTypesCombo()
    {
        $return = [];

        foreach ($this->dataTypesArray() as $item) {
            $return[] = [
                 $item,
                 trans_safe("manage::forms.data_type.$item"),
            ];
        }

        return $return;
    }



    /**
     * @param SettingSetRequest $request
     *
     * @return bool
     */
    public function setFromPanel($request)
    {
        $array = [];

        if (isset($request->default_value)) {
            $array['default_value'] = $request->default_value;
        }

        if ($this->isNotLocalized()) {
            $array['custom_value'] = $request->custom_value;
        } else {
            $custom_value = [];
            foreach (setting('site_locales')->noCache()->gain() as $locale) {
                $custom_value[$locale] = $request->$locale;
            }
            $array['custom_value'] = json_encode($custom_value);
        }

        $this->forgetMyCache();
        return $this->update($array);
    }



    /**
     * suitable for validation request
     *
     * @return string
     */
    public function reservedSlugs()
    {
        return implode(',', $this->reserved_slugs);
    }



    /**
     * @return string
     */
    public function getSeederAttribute()
    {
        $output = null;
        $array  = [
             'slug'          => $this->slug,
             'title'         => $this->title,
             'category'      => $this->category,
             'order'         => $this->order,
             'data_type'     => $this->data_type,
             'default_value' => $this->default_value,
             'hint'          => $this->hint,
             'css_class'     => $this->css_class,
             'is_localized'  => $this->is_localized,
        ];

        foreach ($array as $key => $item) {
            $output .= "'$key' => '$item' ," . LINE_BREAK;
        }

        return $output;
    }
}
