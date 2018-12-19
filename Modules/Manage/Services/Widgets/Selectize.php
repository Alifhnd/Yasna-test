<?php
/**
 * Created by PhpStorm.
 * User: parsa
 * Date: 7/14/18
 * Time: 11:36 AM
 */

namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Selectize extends Widget
{
    protected $type              = "text";
    protected $persist           = false;
    protected $create            = false;
    protected $search_field;
    protected $create_text;
    protected $custom_background;
    protected $ajax_source       = "";
    protected $ajax_source_limit = 2;



    /**
     * custom render of selectize widget
     */
    protected function customRender()
    {
        if (empty($this->value_field)) {
            $this->value_field = 'title';
        }
        if (empty($this->caption_field)) {
            $this->caption_field = 'title';
        }
        if (empty($this->search_field)) {
            $this->search_field = 'title';
        }
        if (empty($this->id)) {
            $this->id = 'selectize';
        }
        if (empty($this->custom_background)) {
            $this->custom_background = "";
        }

        $this->options = json_encode($this->options);
    }



    /**
     * name of selectize blade
     *
     * @return string
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'selectize-form';
        } elseif ($this->label) {
            return 'selectize-labeled';
        } else {
            return 'selectize';
        }
    }
}
