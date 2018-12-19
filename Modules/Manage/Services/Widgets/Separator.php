<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Separator extends Widget
{
    public function customRender()
    {
        if ($this->hidden) {
            $this->container_class .= " noDisplay ";
        }
    }
}
