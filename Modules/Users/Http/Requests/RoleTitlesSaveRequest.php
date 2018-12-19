<?php

namespace Modules\Users\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class RoleTitlesSaveRequest extends YasnaRequest
{
    protected $model_name = "Role";



    /**
     * @inheritdoc
     */
    public function rules()
    {
        $id = $this->data['id'];

        return [
             'title'        => "required|unique:roles,title,$id",
             'plural_title' => 'required',
        ];
    }



    /**
     * @inheritdoc
     */
    public function corrections()
    {
        $this->setLocaleTitles();
    }



    /**
     * Sets Locale Titles
     *
     * @return void
     */
    private function setLocaleTitles(): void
    {
        $this->data['locale_titles'] = [];

        foreach (getSetting('site_locales') as $locale) {
            if ($locale == 'fa') {
                continue;
            }
            $this->data['locale_titles']["title-$locale"]        = $this->data["_title_in_$locale"];
            $this->data['locale_titles']["plural_title-$locale"] = $this->data["_plural_title_in_$locale"];
        }
    }
}
