<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class Button extends Widget
{
    protected $type  = "button";
    protected $shape = "default";
    protected $class = "btn-taha";



    //@TODO: Size

    public function customRender()
    {
        if ($this->hidden) {
            $this->class .= " noDisplay ";
        }

        if ($this->type == 'submit' and !$this->name) {
            $this->name = '_submit';
        }

        if ($this->color) {
            $this->shape = $this->color;
        }
        $this->class = "btn btn-" . $this->shape . SPACE . $this->class;
    }



    public function viewName()
    {
        if ($this->target and $this->target != v0() and $this->type != 'submit') {
            return 'link';
        } else {
            return 'button';
        }
    }
}
