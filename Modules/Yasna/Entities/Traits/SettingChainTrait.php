<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Class SettingChainTrait
 *
 * @package Modules\Yasna\Entities\Traits
 * @property $slug
 * @property $without_purification
 * @method grab(string $slug)
 */
trait SettingChainTrait
{
    private $cache_duration = 100;



    /**
     * Makes an instance of the Setting model, corresponding to the given $slug (typically called from setting() helper)
     *
     * @param null $slug
     *
     * @return $this
     */
    public static function builder($slug = null)
    {
        $model = new self;
        return $model->ask($slug);
    }



    /**
     * @param $slug
     *
     * @return $this
     */
    public function ask($slug, $force_fresh = false)
    {
        if ($force_fresh) {
            return $this->grab($slug);
        }

        $record = Cache::remember("setting-$slug", $this->cache_duration, function () use ($slug) {
            try {
                return $this->where('slug', $slug)->first();
            }
            catch (\Exception $e) {
                return null;
            }
        });

        if (!$record) {
            $record = $this->newInstance();
        }
        $record->slug = $slug;
        return $record;
    }



    /**
     * @return $this
     */
    public function reload()
    {
        return $this->ask($this->slug);
    }



    /**
     * @param $desired_language
     *
     * @return $this
     */
    public function in($desired_language)
    {
        $desired_language = strtolower($desired_language);

        if ($this->isLocalized()) {
            $this->desired_language = $desired_language;
        }

        return $this;
    }



    /**
     * @param bool $value
     *
     * @return $this
     */
    public function noCache($condition = true)
    {
        if (!$condition) {
            return $this;
        }

        $this->forgetMyCache();
        return $this->reload();
    }



    public function withoutPurification()
    {
        $this->without_purification = true;
        return $this;
    }
}
