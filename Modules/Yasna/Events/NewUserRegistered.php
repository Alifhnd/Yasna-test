<?php

namespace Modules\Yasna\Events;

use Modules\Yasna\Services\YasnaEvent;

class NewUserRegistered extends YasnaEvent
{
    public $model_name = 'User';
}
