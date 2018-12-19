<?php
namespace Modules\Manage\Services\Widgets;

class Boolean extends Toggle //<~~ Alias for Toggle
{
    public function customRender()
    {
        $this->widget_name = 'toggle' ;
        parent::customRender() ;
    }
}
