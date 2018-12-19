<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class FormClose extends Widget
{
    public function customRender()
    {
        $this->target = null;
    }

    public function viewName()
    {
        return "form";
    }
}
