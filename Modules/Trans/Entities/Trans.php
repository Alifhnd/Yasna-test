<?php

namespace Modules\Trans\Entities;

use Modules\Yasna\Services\YasnaModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trans extends YasnaModel
{
    use SoftDeletes;

    protected $guarded = ["id"];
    protected $table   = 'translations';



    /**
     * @return collection of this trans
     */
    public function getLocales()
    {
        return model('trans')->where('slug', $this->slug)->get()->pluck('locale');
    }



    /**
     * @return array of trans locales
     */
    public function getLocalesTrans()
    {
        $locales = $this->getLocales();
        $transes = [];
        foreach ($locales as $locale) {
            $transes[] = trans('trans::downstream.locales.' . $locale);
        }
        return $transes;
    }
}
