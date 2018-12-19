<?php namespace Modules\Yasna\Services;

use Illuminate\Queue\SerializesModels;

/**
 * Class YasnaEvent
 *
 * @property mixed  $model
 * @property string $model_name
 * @package Modules\Yasna\Services
 */
abstract class YasnaEvent
{
    use SerializesModels;

    public $model      = false;
    public $model_name = '';



    /**
     * YasnaEvent constructor.
     *
     * @param $model
     */
    public function __construct($model = false)
    {
        if ($model === false) {
            return;
        }
        $this->modelSelector($model);
        $this->chalk();
    }



    /**
     * Gets a model_id or model_hashid or model instance and place a model instance to $this->model.
     *
     * @param $model
     */
    public function modelSelector($model)
    {
        if (!$this->model_name) {
            return;
        }

        if (is_numeric($model) or is_string($model)) {
            $model = model($this->model_name, $model);
        }
        $this->model = $model;
    }



    /**
     * Chalk Helper
     */
    public function chalk()
    {
        $string = "Dispatched `" . $this->moduleName() . ":" . $this->className() . '` Event';
        if ($this->model and $this->model->id) {
            $string .= " (" . $this->model_name . " #" . $this->model->id . ")";
        }
        $string .= ".";

        chalk()->add($string);
    }



    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }



    /*
    |--------------------------------------------------------------------------
    | Module
    |--------------------------------------------------------------------------
    |
    */
    /**
     * @return null
     */
    public function moduleName()
    {
        $name  = get_parent_class($this);
        $array = explode("\\", $name);

        if (array_first($array) == 'Modules') {
            return $array[1];
        }

        return null;
    }



    /**
     * @return mixed
     */
    public static function className()
    {
        $full_name = get_called_class();
        $array     = explode("\\", $full_name);
        return array_last($array);
    }



    /**
     * @return ModuleHelper
     */
    public function module()
    {
        return module($this->moduleName());
    }
}
