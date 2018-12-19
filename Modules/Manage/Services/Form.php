<?php

namespace Modules\Manage\Services;

use Modules\Yasna\Services\GeneralTraits\Serializable;

/**
 * Class Form
 * A Form generator tool, relying on the Widgets system.
 * This is in the very Beta version and need to entirely tested and verified.
 * Future plans: add back-end validation tools.
 * Accessible via a form() helper for easier transportation to the other modules.
 */
class Form
{
    use Serializable;

    /**
     * keep elements of the form
     *
     * @var array
     */
    protected $elements = [];

    /**
     * keep the form authorization method, as a part of back-end validation
     *
     * @var \Closure
     */
    protected $authorization;



    /**
     * get the form elements
     *
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }



    /**
     * set the authorization rule
     *
     * @param \Closure $closure
     *
     * @return void
     */
    public function setAuthorizationRule(\Closure $closure)
    {
        $this->authorization = $closure;
    }



    /**
     * run the authorization process
     *
     * @return bool
     */
    public function authorize()
    {
        $closure = $this->authorization;

        return (bool)$closure();
    }



    /**
     * get the validation rules set by each element of the form, suitable for back-end validation.
     *
     * @return array;
     */
    public function getValidationRules()
    {
        $array = [];

        foreach ($this->getElements() as $element) {
            $array[$element->getName()] = (string)$element->getValidationRules();
        }

        return $array;
    }



    /**
     * get the purification rules set by each element of the form, suitable for back-end validation.
     *
     * @return array
     */
    public function getPurificationRules()
    {
        $array = [];

        foreach ($this->getElements() as $element) {
            $array[$element->getName()] = (string)$element->getPurificationRules();
        }

        return $array;
    }



    /**
     * get the attributes key/label array, suitable for back-end validation.
     *
     * @return array
     */
    public function getAttributeLabels()
    {
        $array = [];

        foreach ($this->getElements() as $element) {
            $element->replaceTrans();
            $array[$element->getName()] = (string)$element->getLabel();
        }

        return $array;
    }



    /**
     * add item to the form
     *
     * @param string $widget_name
     *
     * @return mixed (really mixed)
     */
    public function add($widget_name)
    {
        $this->elements[] = widget($widget_name);

        return array_last($this->elements);
    }



    /**
     * render the form
     *
     * @param array $values
     *
     * @return void
     */
    public function render($values = [])
    {
        foreach ($this->getElements() as $element) {
            $name = $element->getName();
            if(isset($values[$name])) {
                $element->value(urldecode($values[$name]));
            }

            $element->render();
        }
    }



    /**
     * render the form, including a serialized instance of herself
     *
     * @param array $values
     *
     * @return void
     */
    public function renderWithHerself($values = [])
    {
        $this->add("hidden")->value($this->serialize());
        $this->render($values);
    }
}
