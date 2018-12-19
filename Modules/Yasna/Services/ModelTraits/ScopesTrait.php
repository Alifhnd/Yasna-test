<?php
/**
 * Created by PhpStorm.
 * User: parsa
 * Date: 9/22/18
 * Time: 10:33 AM
 */

namespace Modules\Yasna\Services\ModelTraits;


use Illuminate\Database\Eloquent\Builder;

trait ScopesTrait
{
    /**
     * Returns the raw version of the query builder with its values. :)
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return string
     */
    public function scopeToRawSql(Builder $builder)
    {
        $query       = $builder->toSql();
        $bind_values = $builder->getBindings();
        $values      = [];

        foreach ($bind_values as $value) {
            $values[] = "'" . $value . "'";
        }
        $str = str_replace_array('?', $values, $query);

        return $str;
    }



    /**
     * Returns the raw version of the query builder with its values. :)
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return string
     */
    public function scopeGetPlainSql(Builder $builder){
        return $this->scopeToRawSql($builder);
    }
}