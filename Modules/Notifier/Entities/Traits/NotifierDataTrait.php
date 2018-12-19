<?php

namespace Modules\Notifier\Entities\Traits;

trait NotifierDataTrait
{

    /**
     * get data array of the current notifier model
     *
     * @return array
     */
    public function getDataArray(): array
    {
        return (array)$this->getMeta("data");
    }



    /**
     * get a specific data item of the current notifier model
     *
     * @param $item_key
     *
     * @return string|array
     */
    public function getData($item_key = null)
    {
        if (!$item_key) {
            return $this->getDataArray();
        }

        if (isset($this->getDataArray()[$item_key])) {
            return $this->getDataArray()[$item_key];
        }

        return null;
    }



    /**
     * set a specific data item of the current notifier model
     *
     * @param string $item_key
     * @param string $item_value
     *
     * @return bool
     */
    public function setData($item_key, $item_value)
    {
        $array            = $this->getDataArray();
        $array[$item_key] = $item_value;

        $this->cacheForget();

        return $this->updateOneMeta('data', $array);
    }
}
