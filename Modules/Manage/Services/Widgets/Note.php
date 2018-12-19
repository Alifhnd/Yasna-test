<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Note extends Widget
{
    protected $icon = 'exclamation-circle';



    public function customRender()
    {
        if ($this->hidden) {
            $this->class .= ' noDisplay ';
        }
    }
}
