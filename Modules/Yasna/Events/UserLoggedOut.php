<?php

namespace Modules\Yasna\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Yasna\Services\YasnaEvent;

class UserLoggedOut extends YasnaEvent
{
    public $model_name = 'User';



    public function __construct()
    {
        parent::__construct(user());
    }
}
