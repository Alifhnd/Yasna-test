<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Textarea extends Widget
{
    /**
     * Custom Render
     */
    public function customRender()
    {
        $this->rows ?: $this->rows = 5;
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

        if ($this->auto_size) {
            $this->class .= " form-autoSize ";
        }
    }



    /**
     * @return string
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'textarea-form';
        } elseif ($this->label) {
            return 'textarea-labeled';
        } else {
            return 'textarea';
        }
    }
}
