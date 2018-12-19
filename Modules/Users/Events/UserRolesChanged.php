<?php namespace Modules\Users\Events;

use Modules\Yasna\Services\YasnaEvent;

class UserRolesChanged extends YasnaEvent
{
    public $model_name = "User";
}
