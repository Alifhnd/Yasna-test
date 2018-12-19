<?php

namespace Modules\Manage\Entities\Traits;

trait SettingManageTrait
{
    /**
     * get the color in which the entry should appear in the manage panel
     *
     * @return string
     */
    public function getManageColorAttribute()
    {
        return config("manage.setting.panel.$this->slug");
    }



    /**
     * return the set url of the entry, with all sisters together
     *
     * @return string
     */
    public function getManageGroupSetUrlAttribute()
    {
        return route("downstream-setting-action" , [
            "action" => "set-group",
            "hashid" => $this->hashid,
        ]);
    }



    /**
     * return the set url of the entry, alone
     *
     * @return string
     */
    public function getManageSingleSetUrlAttribute()
    {
        return route("downstream-setting-action" , [
             "action" => "set-single",
             "hashid" => $this->hashid,
        ]);
    }



    /**
     * return the icon url of the entry to appear in the manage panel
     *
     * @return string
     */
    public function getManageIconUrlAttribute()
    {
        return module("manage")->getAssetPath("images/settings/$this->category.svg");
    }



    /**
     * return the title of the category, to be shown in the manage panel
     *
     * @return string
     */
    public function getManageCategoryTitleAttribute()
    {
        return trans_safe("manage::settings.categories.$this->category");
    }


}
