<?php
/**
 * Created by PhpStorm.
 * User: jafar
 * Date: 2/23/18
 * Time: 18:36
 */

namespace Modules\Yasna\Services\ModelTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class YasnaCacheScope
 *
 * UNFINISHED TRY
 *
 * @package Modules\Yasna\Services\ModelTraits
 */
class YasnaCacheScope implements Scope
{
    protected $extensions     = ['Remember'];
    private $key;
    private $cache_duration = 1;



    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->generateKey($builder);

        echo LINE_BREAK . $this->key;
    }



    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }



    public function addRemember(Builder $builder)
    {
        $builder->macro('remember', function (Builder $builder) {
            return $this->remember($builder);
        });
    }



    private function generateKey($builder)
    {
        $raw_quarry = $builder->withoutGlobalScopes()->toSql();
        $bindings   = $builder->getBindings();
        $string     = $raw_quarry . " - " . implode(",", $bindings);
        $key        = md5($string);

        return $this->key = $key;
    }



    private function remember($builder)
    {
    }
}
