<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class FormOpen extends Widget
{
    public function customRender()
    {
        $this->target ?: $this->target = '#';
        $this->method ?: $this->method = 'post';
    }

    public function viewName()
    {
        return "form";
    }
}
