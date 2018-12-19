<?php
namespace Modules\Manage\Services\Widgets;

use Modules\Manage\Services\Widget;

class MarkdownEditor extends Widget
{

    /**
     * Custom Render
     */
    public function customRender()
    {
        $this->class .= "markdown-container";
    }



    /**
     * @return string
     */
    public function viewName()
    {
        if ($this->in_form) {
            return 'markdown-editor-form';
        } elseif ($this->label) {
            return 'markdown-editor-labeled';
        } else {
            return 'markdown-editor';
        }
    }
}
