<?php

namespace Modules\Manage\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class DomainSaveRequest extends YasnaRequest
{
    protected $model_name = "Domain";



    public function rules()
    {
        $id             = $this->data['id'];
        $reserved_slugs = model('domain')->reservedSlugs();
        return [
             'title' => "required|unique:domains,title,$id",
             'slug'  => "required|alpha_dash|not_in:$reserved_slugs|unique:domains,slug,$id",
             'alias' => "alpha_dash|not_in:$reserved_slugs|unique:domains,alias,$id|unique:domains,slug,$id",
        ];
    }



    public function purifier()
    {
        return [
             "slug"  => "lower",
             "alias" => "lower",
        ];
    }
}
