<?php

namespace Modules\Yasna\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Yasna\Entities\Traits\SettingCategoryTrait;
use Modules\Yasna\Entities\Traits\SettingChainTrait;
use Modules\Yasna\Entities\Traits\SettingGetTrait;
use Modules\Yasna\Entities\Traits\SettingPanelTrait;
use Modules\Yasna\Entities\Traits\SettingPurifierTrait;
use Modules\Yasna\Entities\Traits\SettingSetTrait;
use Modules\Yasna\Services\YasnaModel;

class Setting extends YasnaModel
{
    use SettingChainTrait;
    use SettingGetTrait;
    use SettingSetTrait;
    use SettingPurifierTrait;
    use SettingPanelTrait;
    use SettingCategoryTrait;
    use SoftDeletes;

    protected $fields_array = ['slug'];
    private $desired_language;



    /**
     * @return bool
     */
    public function isLocalized()
    {
        return boolval($this->is_localized);
    }



    /**
     * @return bool
     */
    public function isNotLocalized()
    {
        return !$this->isLocalized();
    }



    /**
     * Returns current site locale, if not set by the chain methods.
     *
     * @return string
     */
    private function desiredLanguage()
    {
        if ($this->desired_language) {
            return $this->desired_language;
        } else {
            return getLocale();
        }
    }



    /**
     * @return bool
     */
    private function forgetMyCache()
    {
        return cache()->forget("setting-$this->slug");
    }



    /**
     * Checks if a certain setting has been defined.
     *
     * @param $slug
     *
     * @return bool
     */
    public function has($slug)
    {
        return $this->ask($slug)->isDefined();
    }



    /**
     * Checks if a certain setting has not been defined.
     *
     * @param $slug
     *
     * @return bool
     */
    public function hasnot($slug)
    {
        return !$this->has($slug);
    }



    /**
     * @return bool
     */
    public function hasDefaultValue()
    {
        if ($this->data_type == 'boolean') {
            return true;
        }
        return boolval($this->default_value);
    }



    /**
     * @return bool
     */
    public function hasNotDefaultValue()
    {
        return !$this->hasDefaultValue();
    }



    /**
     * @return bool
     */
    public function isUpstream()
    {
        return boolval($this->data_type == 'upstream');
    }



    /**
     * @return bool
     */
    public function isNotUpstream()
    {
        return !$this->isUpstream();
    }



    public function hardDelete()
    {
        $this->forgetMyCache();
        return parent::hardDelete();
    }
}
