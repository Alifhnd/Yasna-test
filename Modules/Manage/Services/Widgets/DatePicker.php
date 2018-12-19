<?php
namespace Modules\Manage\Services\Widgets;

use Carbon\Carbon;

class DatePicker extends Input
{
    protected $j_value = '' ;
    public function customRender()
    {
        parent::customRender() ;
        $this->class .= " datepicker " ;

        if ($this->value) {
            $this->j_value = jdate($this->value)->format('Y/m/d');
            $carbon = new Carbon($this->value);
            $this->value = $carbon->toDateString() ;
        }
    }

    public function viewName()
    {
        return "datepicker" ;
    }
}
