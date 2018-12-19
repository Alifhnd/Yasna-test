<?php

namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Combo extends Widget
{
    protected $size          = 5;
    protected $value_field   = "id";
    protected $caption_field = "title";



    /**
     * Custom Render
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

        if ($this->value_field == 'id' and $this->caption_field == 'title') { //@TODO: Make sure this works fine with other situations.
            if (is_array($this->options)) {
                $sample = $this->options[0];
                if (!isset($sample['id'])) {
                    $this->value_field = '0';
                }
                if (!isset($sample['title'])) {
                    $this->caption_field = '1';
                }
            }
        }
    }



    /**
     * @return string
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'combo-form';
        } elseif ($this->label) {
            return 'combo-labeled';
        } else {
            return 'combo';
        }
    }
}
