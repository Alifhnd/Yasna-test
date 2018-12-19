<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/27/18
 * Time: 2:39 PM
 */

namespace Modules\Notifier\Services\Database;


use Illuminate\Notifications\DatabaseNotification;
use Modules\Yasna\Services\ModuleTraits\ModuleRecognitionsTrait;

class NotificationsHelper
{
    use ModuleRecognitionsTrait;



    /**
     * Registers a notification group.
     *
     * @param string $group_name
     * @param array  $group_info
     */
    public function registerNotificationGroup(string $group_name, array $group_info)
    {
        $this->runningModule()
             ->service('notification_groups')
             ->add($group_name)
             ->value($group_info)
        ;
    }



    /**
     * Returns an array of all the registered notification groups.
     *
     * @return array
     */
    public function getGroupsArray()
    {
        return $this->runningModule()->service('notification_groups')->read();
    }



    /**
     * Returns an array of instances of the `Modules\Notifier\Services\Database\NotificationGroup` class
     * which are created based on the registered notification groups.
     *
     * @return array
     */
    public function getGroups()
    {
        $registered_groups = $this->getGroupsArray();

        return array_map(function ($group) {
            return new NotificationGroup($group['key'], $group['value']);
        }, $registered_groups);
    }



    /**
     * Returns an instance of the `Modules\Notifier\Services\Database\NotificationGroup` class
     * which has been created based on the given group name.
     *
     * @param string $group_name
     *
     * @return NotificationGroup
     */
    public function findGroup(string $group_name)
    {
        $available_groups = $this->getGroups();
        if (array_key_exists($group_name, $available_groups)) {
            return $available_groups[$group_name];
        }

        return NotificationGroup::defaultGroup();
    }



    /**
     * Returns an instance of the `Modules\Notifier\Services\Database\NotificationGroup` class
     * based on the given database notification.
     *
     * @param DatabaseNotification $notification
     *
     * @return NotificationsHelper
     */
    public function getNotificationGroup(DatabaseNotification $notification)
    {
        return NotificationGroup::fromNotification($notification);
    }



    /**
     * Returns a usable link for the given notification.
     *
     * @param DatabaseNotification $notification
     *
     * @return null|string
     */
    public function getNotificationUrl(DatabaseNotification $notification)
    {
        $link = ($notification->data['link'] ?? null);

        if (!$link) {
            return null;
        }

        $url = url($link);

        $url_parts = parse_url($url);
        $query     = ($url_parts['query'] ?? '');
        parse_str($query, $params);

        $params['notification'] = $notification->id;

        // Note that this will url_encode all values
        $url_parts['query'] = http_build_query($params);

        if (str_contains($url, '?')) {
            return $url . '&' . $url_parts['query'];
        } else {
            return $url . '?' . $url_parts['query'];
        }
    }



    /**
     * Returns an instance of the `Modules\Notifier\Services\Database\DataProvider`
     * to be used while providing data while saving a new notification.
     *
     * @return DataProvider
     */
    public function dataProvider()
    {
        return new DataProvider();
    }
}
