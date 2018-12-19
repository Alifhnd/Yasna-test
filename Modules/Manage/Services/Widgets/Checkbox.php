<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Checkbox extends Widget
{
    public function customRender()
    {
        $this->setAutomaticName();
        //$this->setAutomaticLabel(); //TODO: Remove after checking the performance

        $this->help = $this->label ;
        $this->label = null ;

        if ($this->hidden) {
            $this->container_class .= " noDisplay ";
        }

        if ($this->disabled) {
            $this->container_class .= " text-grey ";
            $this->label_style .= " cursor:no-drop; ";
        }
    }

    public function viewName()
    {
        if ($this->in_form) {
            return 'checkbox-form';
        } else {
            return 'checkbox';
        }
    }
}
