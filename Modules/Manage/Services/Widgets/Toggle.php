<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Toggle extends Widget
{
    protected $data_on        = "<i class='fa fa-check'>";
    protected $data_off       = "<i class='fa fa-times'>";
    protected $data_on_style  = "primary";
    protected $data_off_style = "default";
    protected $size           = 50;

    public function customRender()
    {
        if ($this->hidden) {
            $this->container_class .= " noDisplay ";
        }
        $this->setAutomaticLabel() ;
    }
}
