<?php

namespace Modules\Yasna\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Yasna\Services\YasnaModel;

class Domain extends YasnaModel
{
    use SoftDeletes;
    protected $guarded = ['id'];

    protected $reserved_slugs = [
         'domain',
         'global',
         'iran',
         'ir',
         'manage',
         'all',
    ];



    public function reservedSlugs()
    {
        return implode(',', $this->reserved_slugs);
    }



    public function states()
    {
        return $this->hasMany(MODELS_NAMESPACE . 'State');
    }



    public function slugToId($slug)
    {
        return model('domain', $slug)->id;
    }
}
