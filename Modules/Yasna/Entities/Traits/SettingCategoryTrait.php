<?php namespace Modules\Yasna\Entities\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Setting
 * (There might be some old category-related methods, remained in SettingPanelTrait.)
 */
trait SettingCategoryTrait
{
    /**
     * return a builder of all records, grouped by category
     *
     * @return Builder
     */
    public function categories()
    {
        $builder = static::groupBy('category');

        try {
            if (!dev()) {
                $builder = $builder->whereNotIn("category", ['upstream', 'invisible']);
            }
        }
        catch (\Exception $e) {
        }

        return $builder;
    }



    /**
     * return a collection of all records, grouped by category
     *
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories()->orderBy('category')->get();
    }



    /**
     * return the total number of categories
     *
     * @return int
     */
    public function countCategories()
    {
        return $this->getCategories()->count();
        // It's strange, but calling `count()` on the Builder instance, gets a wrong answer!
    }



    /**
     * return a Builder of sisters (= entries with the same category) of a setting entry
     *
     * @return Builder
     */
    public function sisters()
    {
        return static::where('category', $this->category);
    }



    /**
     * return a Collection of sisters of a setting entry
     *
     * @return Collection
     */
    public function getSisters()
    {
        return $this->sisters()->get();
    }
}
