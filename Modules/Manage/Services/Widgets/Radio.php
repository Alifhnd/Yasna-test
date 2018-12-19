<?php namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Radio extends Widget
{
    protected $type          = "radio";
    protected $value_field   = "id";
    protected $caption_field = "title";



    public function customRender()
    {
        $this->setAutomaticName();

        if ($this->in_form) {
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

        if ($this->value_field == 'id' and $this->caption_field == 'title') {
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
}
