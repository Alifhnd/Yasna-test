<?php namespace Modules\Yasna\Services\ModelTraits;

/*
 * Optionally use this trait to add status_text, status_icon and status_color properties to your models.
 */

trait YasnaStatusTrait
{
    /**
     * Utilizes $this->status and looks for a corresponding status.color array in
     * the module config to resolve the $this->status_color property.
     *
     * @return string
     */
    public function getStatusColorAttribute()
    {
        return $this->statusColor($this->status);
    }



    /**
     * Utilizes $this->status and looks for a corresponding status.icon array in
     * the module config to resolve the $this->status_icon property.
     *
     * @return string
     */
    public function getStatusIconAttribute()
    {
        return $this->statusIcon($this->status);
    }



    /**
     * Utilizes $this->status and looks for a corresponding status translation file in
     * the module to resolve the $this->status_text property.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return $this->statusText($this->status);
    }



    /**
     * @param string $status = $this->status
     *
     * @return string
     */
    public function statusColor($status = null)
    {
        if (!$status) {
            $status = $this->status;
        }
        return config($this->moduleAlias() . ".status.color." . $status);
    }



    /**
     * @param string $status = $this->status
     *
     * @return string
     */
    public function statusIcon($status = null)
    {
        if (!$status) {
            $status = $this->status;
        }
        return config($this->moduleAlias() . ".status.icon." . $status);
    }



    /**
     * @param string $status = $this->status
     *
     * @return string
     */
    public function statusText($status = null)
    {
        if (!$status) {
            $status = $this->status;
        }
        return trans_safe($this->moduleAlias() . "::status." . $status);
    }
}
