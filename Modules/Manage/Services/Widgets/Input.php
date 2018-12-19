<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Input extends Widget
{
    protected $type = "text";



    /**
     * @inheritdoc
     */
    public function customRender()
    {
        $this->setAutomaticName();

        if ($this->in_form) {
            $this->setAutomaticLabel();
            if ($this->hidden) {
                $this->container_class .= " noDisplay ";
            }
        } else {
            if ($this->hidden) {
                $this->class .= " noDisplay ";
            }
        }

        if ($this->required) {
            $this->class .= " form-required ";
        }

        if ($this->addon_click and !$this->addon_class) {
            $this->addon_class = 'clickable';
        }


        if ($this->auto_complete) {
            $this->auto_complete = "on";
        } else {
            $this->auto_complete = 'off';
        }
    }



    /**
     * @inheritdoc
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'input-form';
        } elseif ($this->label) {
            return 'input-labeled';
        } else {
            return 'input';
        }
    }
}
