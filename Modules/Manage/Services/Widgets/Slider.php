<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Slider extends Widget
{
    public function customRender()
    {
        if (!$this->value) {
            $this->value = $this->min;
        }
        if (!$this->max) {
            $this->max = "50";
        }
    }

    public function viewName()
    {
        if ($this->in_form) {
            return 'slider-form';
        } elseif ($this->label) {
            return 'slider-labeled';
        } else {
            return 'slider';
        }
    }
}
