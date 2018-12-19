<?php
/**
 * Created by PhpStorm.
 * User: emitis
 * Date: 10/27/18
 * Time: 5:47 PM
 */

namespace Modules\Notifier\Services\Database;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class DataProvider implements Arrayable, Jsonable
{
    protected $group;
    protected $content = null;
    protected $message = null;
    protected $link    = null;



    /**
     * Sets the group property with a valid notification group based on the given group.
     *
     * @param string $group_name
     *
     * @return $this
     */
    public function group(string $group_name)
    {
        $this->group = databaseNotification()->findGroup($group_name);

        return $this;
    }



    /**
     * Sets the content property.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content(string $content)
    {
        $this->content = $content;

        return $this;
    }



    /**
     * Sets the message property.
     *
     * @param string $message
     *
     * @return $this
     */
    public function message(string $message)
    {
        $this->message = $message;

        return $this;
    }



    /**
     * Sets the link property.
     *
     * @param string $link
     *
     * @return $this
     */
    public function link(string $link)
    {
        $this->link = $link;

        return $this;
    }



    /**
     * Returns the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
             'group'   => $this->group->getName(),
             'content' => $this->content,
             'message' => $this->message,
             'link'    => $this->link,
        ];
    }



    /**
     * Converts the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
