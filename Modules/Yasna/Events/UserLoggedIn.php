<?php

namespace Modules\Yasna\Events;

use Modules\Yasna\Services\YasnaEvent;

class UserLoggedIn extends YasnaEvent
{
    public $model_name = 'User';
}
