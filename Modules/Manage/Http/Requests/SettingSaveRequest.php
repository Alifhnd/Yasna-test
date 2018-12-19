<?php

namespace Modules\Manage\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class SettingSaveRequest extends YasnaRequest
{
    protected $model_name = "Setting";



    /**
     * @inheritdoc
     */
    public function rules()
    {
        $id                 = $this->data['id'];
        $reserved_slugs     = $this->model->reservedSlugs();
        $allowed_categories = $this->model->categoryList();
        $allowed_types      = $this->model->dataTypeList();

        return [
             'title'     => "required|unique:settings,title,$id",
             "slug"      => "required|alpha_dash|not_in:$reserved_slugs|unique:settings,slug,$id",
             'order'     => "required|numeric",
             'category'  => "required|in:$allowed_categories",
             'data_type' => "required|in:$allowed_types",
        ];
    }



    /**
     * @inheritdoc
     */
    public function purifier()
    {
        return [
             'order'            => "ed|numeric",
             'is_localized'     => "boolean",
             "api_discoverable" => "boolean",
        ];
    }
}
