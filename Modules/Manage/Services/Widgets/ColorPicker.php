<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class ColorPicker extends widget
{
    public function customRender()
    {
        if (!$this->value) {
            $this->value = " ";
        }
    }

    public function viewName()
    {
        if ($this->in_form) {
            return 'colorpicker-form';
        } elseif ($this->label) {
            return 'colorpicker-labeled';
        } else {
            return 'colorpicker';
        }
    }
}
