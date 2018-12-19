<?php

namespace Modules\Notifier\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class NotifierRequest extends YasnaRequest
{
    protected $model_name = "notifier";



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             "slug"                 => "string|min:8|max:20",
             "title"                => "required|string|min:4|max:35",
             "channel"              => "required|string|min:4|max:20",
             "driver"               => "required|string|min:4|max:20",
             "available_for_admins" => "boolean",
        ];
    }
}
