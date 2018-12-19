<?php

namespace Modules\Manage\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class SettingSetRequest extends YasnaRequest
{
    protected $model_name = "setting";



    public function authorize()
    {
        return user()->as('admin')->can('settings.settings');
    }



    public function corrections()
    {
        if (!dev()) {
            unset($this->data['default_value']);
        }
    }
}
