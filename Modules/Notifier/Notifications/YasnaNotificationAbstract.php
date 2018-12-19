<?php

namespace Modules\Notifier\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Notifier\Channels\SmsChannel;

class YasnaNotificationAbstract extends Notification
{
    use Queueable;



    /**
     * Yasna SMS channel for easier calls
     * @return mixed
     */
    final public function yasnaSmsChannel()
    {
        return SmsChannel::class;
    }



    /**
     * Yasna mail channel for easier calls
     *
     * @return string
     */
    final public function yasnaMailChannel()
    {
        return 'mail';
    }
}
