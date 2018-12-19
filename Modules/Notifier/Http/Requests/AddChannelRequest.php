<?php

namespace Modules\Notifier\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class AddChannelRequest extends YasnaRequest
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             'channel'      => 'required',
             'driver_title' => 'required',
             'driver_name'  => 'required',
             'fields_name'  => 'required',
        ];
    }



    /**
     * @inheritdoc
     */
    public function corrections()
    {
        $this->data['channel'] = str_replace(' ', '', $this->data['channel']);
    }



    /**
     * @inheritdoc
     */
    public function messages()
    {
        return [
             'driver_title.required' => trans('notifier::general.miss-driver-title'),
             'driver_name.required'  => trans('notifier::general.miss-driver-name'),
             'fields_name.required'  => trans('notifier::general.miss-fields-name'),
             'channel.required'      => trans('notifier::general.miss-channel-name'),
        ];
    }
}
