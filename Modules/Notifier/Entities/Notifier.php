<?php

namespace Modules\Notifier\Entities;

use Modules\Notifier\Entities\Traits\NotifierChannelsTrait;
use Modules\Notifier\Entities\Traits\NotifierDataTrait;
use Modules\Notifier\Entities\Traits\NotifierDefaultDriverTrait;
use Modules\Notifier\Entities\Traits\NotifierDriversTrait;
use Modules\Notifier\Entities\Traits\NotifierHelperTrait;
use Modules\Yasna\Services\YasnaModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifier extends YasnaModel
{
    const CACHE_DURATION       = 100;
    const DEFAULT_SETTING_SLUG = "default_notifiers";

    use SoftDeletes;
    use NotifierChannelsTrait;
    use NotifierDriversTrait;
    use NotifierDataTrait;
    use NotifierHelperTrait;
    use NotifierDefaultDriverTrait;



    /**
     * get a safe instance of a notifier, corresponding to the given channel and driver
     *
     * @param string $channel
     * @param string $driver
     *
     * @return \App\Models\Notifier
     */
    public static function locate(string $channel, string $driver)
    {
        $slug = static::generateSlug($channel, $driver);

        return cache()->remember("notifier-$slug", static::CACHE_DURATION, function () use ($slug) {
            return notifier($slug);
        });
    }



    /**
     * @inheritdoc
     */
    public function batchSave($request, $overflow_parameters = [])
    {
        $this->cacheForget();
        return parent::batchSave($request, $overflow_parameters);
    }



    /**
     * forgets the store cache relative to the current record.
     *
     * @return void
     */
    public function cacheForget()
    {
        cache()->forget("notifier-$this->slug");
    }



    /**
     * get main meta fields
     *
     * @return array
     */
    public function mainMetaFields()
    {
        return [
             'data',
        ];
    }
}
