<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Group extends Widget
{
    public function customRender()
    {
        $this->container_class = $this->class;
        $this->container_extra = $this->extra;
        $this->container_style = $this->style;
        $this->inside_blade    = $this->blade;
    }
}
