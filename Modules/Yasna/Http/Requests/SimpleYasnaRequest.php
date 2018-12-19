<?php

namespace Modules\Yasna\Http\Requests;

use Modules\Yasna\Services\YasnaRequest;

/**
 * Class SimpleYasnaRequest
 * This is a replacement of using Illuminate/Request, for the times a very simple request is going to be used just to
 * safely receive request data in the Controller.
 * DO NOT USE THIS when a mass-assignment or save action is being executed in the Controller.
 *
 * @package Modules\Yasna\Http\Requests
 */
class SimpleYasnaRequest extends YasnaRequest
{
}
