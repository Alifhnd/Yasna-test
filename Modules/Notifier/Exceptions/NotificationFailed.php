<?php
/**
 * Created by PhpStorm.
 * User: jafar
 * Date: 8/5/18
 * Time: 16:55
 */

namespace Modules\Notifier\Exceptions;

class NotificationFailed extends \Exception
{
    /**
     * throw error when the connection fails.
     *
     * @return static
     */
    public static function connectionError()
    {
        return new static("Failed to connect the notification provider.");
    }



    /**
     * throw error when the submission fails.
     * @param string $message
     *
     * @return static
     */
    public static function submissionError(string $message)
    {
        return new static("Failed to submit to notification provider: $message");
    }
}
