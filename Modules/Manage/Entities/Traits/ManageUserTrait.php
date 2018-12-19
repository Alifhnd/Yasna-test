<?php

namespace Modules\Manage\Entities\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ManageUserTrait
{
    /**
     * @param null $default
     *
     * @return string
     */
    public function adminTheme($default = null)
    {
        $default_theme = (getSetting('manage-default-theme') ?: $default);
        return $this->preference('admin_theme', $default_theme);
    }



    /**
     * Returns a limited version of the `notifications()` relationship.
     *
     * @param int $limit
     *
     * @return MorphMany
     */
    public function lastNotifications(int $limit = 10)
    {
        return $this->notifications()->limit($limit);
    }
}
