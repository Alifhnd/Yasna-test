<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Modal extends Widget
{
    protected $size = "sm" ;
    protected $method = "post" ;
    public function customRender()
    {
        $this->class .= ' js ' ;
    }
}
