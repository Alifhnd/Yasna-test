<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/27/18
 * Time: 2:43 PM
 */

namespace Modules\Notifier\Services\Database;


use Illuminate\Notifications\DatabaseNotification;

class NotificationGroup
{
    /**
     * The Default Notification Group.
     */
    const DEFAULT_GROUP = 'notification';
    /**
     * The Default Notification Color
     */
    const DEFAULT_COLOR = 'warning';
    /**
     * The Default Notification Icon
     */
    const DEFAULT_ICON  = 'bell';

    /**
     * The Name of the Group
     *
     * @var string
     */
    protected $name;
    /**
     * The Information of the Group
     *
     * @var array
     */
    protected $info;



    /**
     * Creates an instance of this class based on the given database notification.
     *
     * @param DatabaseNotification $notification
     *
     * @return NotificationsHelper
     */
    public static function fromNotification(DatabaseNotification $notification)
    {
        $group_name = ($notification->data['group'] ?? static::DEFAULT_GROUP);

        return databaseNotification()->findGroup($group_name);
    }



    /**
     * Creates an instance of this class with default information.
     *
     * @return NotificationGroup
     */
    public static function defaultGroup()
    {
        $group_name = static::DEFAULT_GROUP;
        $group_info = [
             'color' => static::DEFAULT_COLOR,
             'icon'  => static::DEFAULT_ICON,
        ];

        return new static($group_name, $group_info);
    }



    /**
     * NotificationGroup constructor.
     *
     * @param string $group_name
     * @param array  $group_info
     */
    public function __construct(string $group_name, array $group_info = [])
    {
        $this->name = $group_name;
        $this->info = $group_info;
    }



    /**
     * Returns the name of the group.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }



    /**
     * Returns the color of the group.
     *
     * @return string
     */
    public function getColor()
    {
        return ($this->info['color'] ?? static::DEFAULT_COLOR);
    }



    /**
     * Returns the icon of the group.
     *
     * @return string
     */
    public function getIcon()
    {
        return ($this->info['icon'] ?? static::DEFAULT_ICON);
    }
}
