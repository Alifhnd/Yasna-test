<?php

namespace Modules\Manage\Services\Widgets;

use Carbon\Carbon;

class PersianDatePicker extends Input
{
    protected $format;
    protected $value_from;
    protected $value_to;
    protected $value;
    protected $min;
    protected $max;
    protected $placeholder_to;
    protected $placeholder_from;
    protected $value_type       = "gregorian";
    protected $calendar_type    = "persian";
    protected $only_time_picker = false;
    protected $calendar_switch  = true;
    protected $scroll           = true;
    protected $time_picker      = true;
    protected $range            = false;



    /**
     * Custom Render
     */
    public function customRender()
    {
        $this->allToString();
    }



    /**
     * Converts boolean value to string word
     *
     * @param $argument
     *
     * @return string
     */
    private function toString($argument)
    {
        if ($argument) {
            return "true";
        } else {
            return "false";
        }
    }



    /**
     * Calls toString to all boolean properties
     */
    private function allToString()
    {
        $this->only_time_picker = $this->toString($this->only_time_picker);
        $this->calendar_switch  = $this->toString($this->calendar_switch);
        $this->scroll           = $this->toString($this->scroll);
        $this->time_picker      = $this->toString($this->time_picker);
        $this->range            = $this->toString($this->range);
    }



    /**
     * @return string
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'persian-datepicker-form';
        } elseif ($this->label) {
            return 'persian-datepicker-labeled';
        } else {
            return 'persian-datepicker';
        }
    }



    /**
     * @param string $value
     *
     * @return $this|null
     */
    public function value($value)
    {
        $this->value_from = (string) $value;
        return $this;
    }



    /**
     * @param string $type
     *
     * @return $this
     */
    public function calendarType(string $type)
    {
        $this->calendar_type = $type;
        return $this;
    }



    /**
     * @param string $type
     *
     * @return $this
     */
    public function initialValueType(string $type)
    {
        $this->value_type = $type;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function inRange(bool $condition = true)
    {
        $this->range = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function withTime(bool $condition = true)
    {
        $this->time_picker = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function withoutTime(bool $condition = false)
    {
        $this->format      = 'dddd D MMMM YYYY';
        $this->time_picker = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function onlyDatePicker(bool $condition = false)
    {
        $this->format           = 'dddd D MMMM YYYY';
        $this->only_time_picker = $condition;
        $this->time_picker      = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function onlyTimePicker(bool $condition = true)
    {
        $this->format           = 'HH:mm';
        $this->only_time_picker = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function canScroll(bool $condition = true)
    {
        $this->scroll = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function cannotScroll(bool $condition = false)
    {
        $this->scroll = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @deprecated
     * @return $this
     */
    public function withSwitch(bool $condition = true)
    {
        $this->calendar_switch = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @deprecated
     * @return $this
     */
    public function withoutSwitch(bool $condition = false)
    {
        $this->calendar_switch = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function canSwitch(bool $condition = true)
    {
        $this->calendar_switch = $condition;
        return $this;
    }



    /**
     * @param bool $condition
     *
     * @return $this
     */
    public function cannotSwitch(bool $condition = false)
    {
        $this->calendar_switch = $condition;
        return $this;
    }



    /**
     * @param string $limit
     *
     * @return $this
     */
    public function min(string $limit)
    {
        $this->min = $limit;

        if (str_contains($limit, '-')) {
            $carbon    = new Carbon($limit);
            $this->min = $carbon->timestamp * 1000;
        }
        return $this;
    }



    /**
     * @param string $limit
     *
     * @return $this
     */
    public function max(string $limit)
    {
        $this->max = $limit;

        if (str_contains($limit, '-')) {
            $carbon    = new Carbon($limit);
            $this->max = $carbon->timestamp * 1000;
        }
        return $this;
    }



    /**
     * @param string $value
     *
     * @return $this
     */
    public function placeholderFrom(string $value)
    {
        $this->placeholder_from = $value;

        if (str_contains($value, 'tr:')) {
            $trans                  = trans(str_after($value, 'tr:'));
            $this->placeholder_from = $trans;
        }

        return $this;
    }



    /**
     * @param string $value
     *
     * @return $this
     */
    public function placeholderTo(string $value)
    {
        $this->placeholder_to = $value;

        if (str_contains($value, 'tr:')) {
            $trans                = trans(str_after($value, 'tr:'));
            $this->placeholder_to = $trans;
        }

        return $this;
    }



    /**
     * @param string $value
     *
     * @return $this
     */
    public function placeholder(string $value)
    {
        $this->placeholderFrom($value);
        return $this;
    }
}
