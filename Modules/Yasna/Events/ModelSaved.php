<?php namespace Modules\Yasna\Events;

use Modules\Yasna\Services\YasnaEvent;

class ModelSaved extends YasnaEvent
{
    public function __construct($model)
    {
        //cache()->flush(); //@TODO: Not a good idea. Find a way to clear the necessary cache only.
    }
}
