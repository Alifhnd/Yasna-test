<?php

namespace Modules\Notifier\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

class EditChannelRequest extends YasnaRequest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
             'channel'      => 'required',
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
             'channel.required'      => trans('notifier::general.miss-channel-name'),
        ];
    }
}
