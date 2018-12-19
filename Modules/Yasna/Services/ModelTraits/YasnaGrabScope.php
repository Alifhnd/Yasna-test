<?php namespace Modules\Yasna\Services\ModelTraits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class YasnaGrabScope implements Scope
{
    protected $extensions     = ['Grab'];
    protected $column_name    = null;
    protected $needle         = 0;
    protected $eloquent_model = null;



    /**
     * @param Builder $builder
     * @param Model   $model
     */
    public function apply(Builder $builder, Model $model)
    {
    }



    /**
     * @param Builder $builder
     */
    public function extend(Builder $builder)
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }
    }



    /**
     * @param Builder $builder
     */
    public function addGrab(Builder $builder)
    {
        $builder->macro('grab', function (Builder $builder, $needle, $field_name = null) {
            return $this->grab($builder, $needle, $field_name);
        });
        $builder->macro('grabId', function (Builder $builder, $needle) {
            return $this->grabId($builder, $needle);
        });
        $builder->macro('grabHashid', function (Builder $builder, $needle) {
            return $this->grabHashid($builder, $needle);
        });
        $builder->macro('grabSlug', function (Builder $builder, $needle) {
            return $this->grabSlug($builder, $needle);
        });
    }



    /**
     * @param      $builder
     * @param      $needle
     * @param null $field_name
     *
     * @return Model
     */
    private function grab($builder, $needle, $field_name = null)
    {
        $this->needle      = trim($needle);
        $this->column_name = $field_name;

        $this->setGrabColumnName($builder);
        $this->getEloquentModel($builder);
        return $this->model($builder);
    }



    /**
     * @param $builder
     * @param $needle
     *
     * @return Model
     */
    private function grabId($builder, $needle)
    {
        return $this->grab($builder, intval($needle), 'id');
    }



    /**
     * @param $builder
     * @param $needle
     *
     * @return Model
     */
    private function grabHashid($builder, $needle)
    {
        return $this->grabId($builder, hashid($needle));
    }



    /**
     * @param $builder
     * @param $needle
     *
     * @return Model
     */
    private function grabSlug($builder, $needle)
    {
        return $this->grab($builder, $needle, 'slug');
    }



    /**
     * @param $builder
     */
    private function setGrabColumnName($builder)
    {
        /*-----------------------------------------------
        | When a particular column is specified ...
        */
        if ($this->column_name) {
            return;
        }


        /*-----------------------------------------------
        | When it's an `id` ...
        */
        if (is_numeric($this->needle)) {
            $this->column_name = 'id';
            return;
        }

        /*-----------------------------------------------
        | When it's a valid hashid ...
        */
        if (is_numeric(hashid($this->needle))) {
            $this->needle      = hashid($this->needle);
            $this->column_name = 'id';
            return;
        }


        /*-----------------------------------------------
        | When it's a slug ...
        */
        if ($builder->getModel()->hasField('slug')) {
            $this->column_name = 'slug';
            return;
        }

        /*-----------------------------------------------
        | Otherwise ...
        */
        $this->column_name = 'id';
    }



    /**
     * @param $builder
     */
    private function getEloquentModel($builder)
    {
        if ($this->needle) {
            $this->eloquent_model = $builder->where($this->column_name, $this->needle)->first();
        } else {
            $this->eloquent_model = null;
        }
    }



    /**
     * @param $builder
     *
     * @return Model
     */
    private function model($builder)
    {
        if ($this->eloquent_model) {
            return $this->eloquent_model;
        } else {
            return $builder->getModel()->newInstance();
        }
    }
}
