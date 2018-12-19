<?php

namespace Modules\Manage\Services;

use Illuminate\Support\Facades\View;

class Widget
{
    protected static $view_folder           = "manage::widgets101.";
    protected        $widget_name           = null;
    protected        $condition             = true;
    protected        $invalid               = false;
    protected        $model;
    protected        $id;
    protected        $name;
    protected        $tooltip;
    protected        $value;
    protected        $min                   = 0;
    protected        $max;
    protected        $step                  = 1;
    protected        $class;
    protected        $style;
    protected        $font_size;
    protected        $rows;
    protected        $ltr;
    protected        $rtl;
    protected        $size;
    protected        $auto_size;
    protected        $on_click;
    protected        $on_change;
    protected        $on_blur;
    protected        $on_focus;
    protected        $extra_array           = [];
    protected        $extra;
    protected        $disabled              = false;
    protected        $required              = false;
    protected        $target;
    protected        $method;
    protected        $validation_rules;
    protected        $purification_rules;
    protected        $validation            = true;
    protected        $ajax                  = true;
    protected        $number_format         = false;
    protected        $type;
    protected        $shape                 = 'default';
    protected        $color;
    protected        $placeholder;
    protected        $new_window;
    protected        $group_class;
    protected        $icon;
    protected        $label;
    protected        $label_class;
    protected        $label_style;
    protected        $addon;
    protected        $addon_class;
    protected        $addon_click;
    protected        $help;
    protected        $auto_complete;
    protected        $help_class;
    protected        $help_style;
    protected        $help_click;
    protected        $container_id;
    protected        $container_class;
    protected        $container_style;
    protected        $container_extra_array = [];
    protected        $container_extra;
    protected        $searchable            = false;
    protected        $search_placeholder    = "tr:manage::forms.button.search";
    protected        $blank_value;
    protected        $inside_blade;
    protected        $blade;
    protected        $blank_caption;
    protected        $options               = [];
    protected        $value_field;
    protected        $caption_field;
    protected        $in_form               = false;
    protected        $hidden                = false;
    protected        $debug                 = false;
    protected        $force_persian         = false;
    protected        $separated             = false;
    protected        $caption_properties    = [
         'label',
         'placeholder',
         'addon',
         'tooltip',
         'help',
         'search_placeholder',
         'blank_caption',
    ];
    protected        $link_properties       = ['target', 'addon_click'];
    protected        $extra_properties      = ['extra', 'container_extra'];
    protected        $boolean_properties    = [
         'ltr',
         'rtl',
         'auto_size',
         'disabled',
         'required',
         'validation',
         'ajax',
         'number_format',
         'new_window',
         'searchable',
         'in_form',
         'hidden',
         'debug',
         'force_persian',
         'separated',
         'auto_complete',
    ];



    /*
    |--------------------------------------------------------------------------
    | Builder
    |--------------------------------------------------------------------------
    |
    */

    public function __construct($widget_name, $valid = true)
    {
        $this->widget_name = $widget_name;
        $this->invalid     = !$valid;
    }



    public static function builder($widget_name)
    {
        $class_name = "\\Modules\\Manage\\Services\\Widgets\\" . studly_case($widget_name);

        /*-----------------------------------------------
        | If Not Supported ...
        */
        if (!class_exists($class_name)) {
            return new self($widget_name, false);
        }

        /*-----------------------------------------------
        | Instance Generation ...
        */
        return new $class_name($widget_name);
    }



    /*
    |--------------------------------------------------------------------------
    | Chain Methods
    |--------------------------------------------------------------------------
    |
    */

    public function __call($name, $arguments)
    {
        $property_name = snake_case($name);

        /*-----------------------------------------------
        | Debug Helper ...
        */
        if ($this->debug) {
            ss($name);
        }

        /*-----------------------------------------------
        | Getter ...
        */
        if (substr($name, 0, 3) === "get") {
            $property_name = snake_case(str_after($name, "get"));
            return $this->$property_name;
        }


        /*-----------------------------------------------
        | conditioned call: widget()->folanIf( $condition , $other_arguments) ...
        */
        if (str_contains($name, 'If')) {
            $name      = str_before($name, 'If');
            $condition = array_shift($arguments);
            if (boolval($condition)) {
                return $this->$name(... $arguments);
            } else {
                return $this;
            }
        }

        /*-----------------------------------------------
        | Boolean Setup ...
        */
        if (!isset($arguments[0])) {
            if (in_array($property_name, $this->boolean_properties)) {
                $this->$property_name = true;
            } else {
                $this->$property_name = null;
            }
        } /*-----------------------------------------------
        | Extra Fields ...
        */
        elseif (in_array($property_name, $this->extra_properties) and isset($arguments[1])) {
            $this->setExtra($property_name . "_array", $arguments[0], $arguments[1]);
        } /*-----------------------------------------------
        | Normal Situation ...
        */
        else {
            $this->$property_name = $arguments[0];
        }

        /*-----------------------------------------------
        | Return ...
        */
        return $this;
    }



    public function newWindow($switch = true)
    {
        if ($switch) {
            $this->new_window = "_blank";
        }

        return $this;
    }



    public function addon($addon_title, $addon_click = null, $addon_class = 'text-bold')
    {
        $this->addon       = $addon_title;
        $this->addon_click = $addon_click;
        $this->addon_class = $addon_class;
        return $this;
    }



    public function label($label_title, $label_class = null, $label_style = null)
    {
        $this->label       = $label_title;
        $this->label_class = $label_class;
        $this->label_style = $label_style;
        return $this;
    }



    public function setExtra($tag, $value, $property = null)
    {
        //@TODO: Not workong on the containers etc.

        if ($property) {
            $property = $property . "_extra_array";
        } else {
            $property = "extra_array";
        }

        $this->$property[$tag] = $value;
        return $this;
    }



    public function start()
    {
        $this->type = 'start';
        return $this;
    }



    public function stop()
    {
        $this->type = 'stop';
        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | Process
    |--------------------------------------------------------------------------
    |
    */
    protected function setAutomaticId()
    {
        /*-----------------------------------------------
        | Id ...
        */
        if (!isset($this->id)) {
            $this->id = "widget-$this->widget_name-" . rand(1000, 9999) . rand(1000, 9999);
        }

        /*-----------------------------------------------
        | Container Id ...
        */
        if (!isset($this->container_id)) {
            $this->container_id = $this->id . "-container";
        }

        /*-----------------------------------------------
        | Return (despite set already) ...
        */
        return $this->id;
    }



    protected function setAutomaticName()
    {
        /*-----------------------------------------------
        | If Given Already ...
        */
        if (isset($this->name)) {
            return $this->name;
        }

        /*-----------------------------------------------
        | Random Name ...
        */
        return $this->name = "_" . $this->id;
    }



    protected function setAutomaticLabel()
    {
        /*-----------------------------------------------
        | If Given Already ...
        */
        if ($this->label) {
            return $this->label;
        }

        /*-----------------------------------------------
        | Automatic Label ...
        */
        return $this->label = trans_safe("validation.attributes.$this->name");
    }



    protected function toArray()
    {
        $array = [];
        foreach ($this as $property => $value) {
            $array[$property] = $value;
        }

        return $array;
    }



    protected function view()
    {
        echo view(self::$view_folder . $this->viewName(), $this->toArray());
        if ($this->debug) {
            ss($this->toArray());
        }

        return '';
    }



    public function viewName()
    {
        $default_view = kebab_case($this->widget_name);
        if ($this->in_form) {
            return $default_view . "-form";
        } else {
            return $default_view;
        }
    }



    /**
     * replace all caption fields with their translations if requested
     *
     * @param array $properties
     */
    public function replaceTrans($properties = false)
    {
        if ($properties === false) {
            $properties = $this->caption_properties;
        }

        foreach ($properties as $property) {
            $this->$property = str_replace("tr:", "trans:", $this->$property);
            if (str_contains($this->$property, 'trans:')) {
                $this->$property = trans_safe(str_after($this->$property, 'trans:'));
            }
        }
    }



    protected function replaceLinks($properties)
    {
        foreach ($properties as $property) {
            /*-----------------------------------------------
            | Named Routes ...
            */
            if (str_contains($this->$property, "name:")) {
                $this->$property = route(str_after($this->$property, "name:"));
            }

            /*-----------------------------------------------
            | Modal Switch ...
            */
            if (str_contains($this->$property, "modal:")) {
                $this->$property = "masterModal( '" . url(str_after($this->$property, "modal:")) . "' )";
            }

            /*-----------------------------------------------
            | Url Switch ...
            */
            if (str_contains($this->$property, "url:")) {
                $this->$property = url(str_after($this->$property, "url:"));
            }
        }
    }



    protected function forcePersianWhenRequired()
    {
        if (!$this->force_persian) {
            return;
        }
        foreach ($this->caption_properties as $property) {
            $this->$property = pd($this->$property);
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Render
    |--------------------------------------------------------------------------
    |
    */

    public function __toString()
    {
        $this->render();
        return '';
    }



    public function shutUp()
    {
        return null;
    }



    public function render()
    {
        /*-----------------------------------------------
        | Check the boolean $condition ...
        */
        if (!$this->condition) {
            return null;
        }

        /*-----------------------------------------------
        | If Not Supported ...
        */
        if ($this->invalid) {
            echo "Invalid Widget " . $this->widget_name;
            return null;
        }

        /*-----------------------------------------------
        | Settings Render ...
        */
        $this->masterRender();
        $this->customRender();

        /*-----------------------------------------------
        | View ...
        */
        return $this->view();
    }



    public function masterRender()
    {
        $this->setAutomaticId();
        $this->replaceTrans();
        $this->replaceLinks($this->link_properties);
        $this->forcePersianWhenRequired();
        $this->renderTarget();
        $this->renderExtra();
        $this->renderDirection();
        $this->renderRequestedClasses();
        $this->renderBlades();
    }



    protected function customRender()
    {
        //Intentionally left blank, for the safety purposes.
    }



    protected function renderTarget()
    {
        if (str_contains($this->target, '(')) {
            $this->on_click = $this->target;
            $this->target   = v0();
        }
    }



    protected function renderRequestedClasses()
    {
        if ($this->number_format) {
            $this->class .= " form-numberFormat ";
        }
    }



    protected function renderExtra()
    {
        foreach ($this->extra_properties as $property) {
            $source = $property . "_array";
            /*-----------------------------------------------
            | Safety ...
            */
            if (!$this->$source or !is_array($this->$source)) {
                $this->$property = "";
                continue;
            }

            /*-----------------------------------------------
            | Process ...
            */
            $result = "";
            foreach ($this->$source as $key => $value) {
                $result .= " $key=$value ";
            }

            /*-----------------------------------------------
            | Result ...
            */
            $this->$property = $result;
        }
    }



    protected function renderDirection()
    {
        if ($this->ltr) {
            $this->class .= " ltr ";
        }
        if ($this->rtl) {
            $this->class .= ' rtl ';
        }
    }



    protected function renderBlades()
    {
        foreach ($this->toArray() as $key => $value) {
            if (!str_contains($key, 'blade') or !$value) {
                continue;
            }

            if (!View::exists($value)) {
                $this->$key = "manage::widgets101.invalid";

                if (config('app.debug')) {
                    $this->label = "view file [$value] not found!";
                }
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Semi-Static Servants
    |--------------------------------------------------------------------------
    |
    */
    public function viewPath($view_file)
    {
        if (str_contains($view_file, '::')) {
            return $view_file;
        }
        return self::$view_folder . $view_file;
    }
}
