<?php namespace Modules\Yasna\Services\ModelTraits;

use Morilog\Jalali\jDate;
use Carbon\Carbon;

trait HelpersTrait
{
    /**
     * @return string
     */
    public function now()
    {
        return Carbon::now()->toDateTimeString();
    }



    /**
     * @param string $field
     * @param string $locale
     *
     * @return string
     */
    public function relativeDate($field = 'created_at', $locale = 'auto')
    {
        if ($locale == 'auto') {
            $locale = getLocale();
        }

        if ($locale == 'fa') {
            return pd(jDate::forge($this->$field)->ago());
        } else {
            $carbon = new Carbon($this->$field);
            return $carbon->diffForHumans();
        }
    }



    /**
     * Returns last [$number]th record of the table
     *
     * @param int $number
     *
     * @return $this
     */
    public function last($number = 1)
    {
        $model = $this->orderBy('created_at', 'desc')->limit($number)->get()->last();

        if (!$model) {
            return $this->newInstance();
        }

        return $model;
    }
}
