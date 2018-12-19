<?php

namespace Modules\Manage\Http\Requests;

use GuzzleHttp\Client;
use Modules\Yasna\Services\YasnaRequest;

class SupportRequest extends YasnaRequest
{
    /**
     * The token to be used int the API calls
     *
     * @var string|null
     */
    protected $token;



    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return yasnaSupport()->isAuthorized();
    }
}
