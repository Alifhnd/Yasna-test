<?php namespace Modules\Yasna\Services\ModelTraits;

trait YasnaFormTrait
{
    private $form_items     = [];
    private $current_field  = null;
    private $auto_increment = 0;



    /**
     * Calls all form items, by individually going through each method.
     */
    protected function loadFormItems()
    {
        foreach ($this->listFormItemMethods() as $method) {
            $this->$method();
        }
    }



    /**
     * @param string $field_name
     *
     * @return $this
     */
    protected function addFormItem(string $field_name)
    {
        $this->current_field = $field_name;
        $this->auto_increment++;

        $this->form_items[$field_name] = [
             "field_name"         => $field_name,
             "order"              => $this->auto_increment,
             "label"              => trans_safe("validation.attributes.$field_name"),
             "hint"               => null,
             "purification_rules" => null,
             "validation_rules"   => null,
             "class"              => null,
             "style"              => null,
             "extra"              => null,
             //"is_separator"       => false,
             "is_required"        => null,
             "type"               => "input",
        ];

        return $this;
    }



    /**
     * @param string $separator_name
     *
     * @return $this
     */
    protected function addFormSeparator(string $separator_name)
    {
        $this->addFormItem($separator_name);

        return $this->setFormElementAttribute('type', 'separator');
    }



    /**
     * @param string $field_name
     */
    protected function removeFormItem(string $field_name)
    {
        unset($this->form_items[$field_name]);
    }



    /**
     * @param string $field_name
     *
     * @return $this
     */
    protected function modifyFormItem(string $field_name)
    {
        $this->current_field = $field_name;
        return $this;
    }



    /**
     * @param string $new_name
     *
     * @return $this
     */
    protected function withName(string $new_name)
    {
        $this->form_items[$new_name] = $this->form_items[$this->current_field];
        unset($this->form_items[$this->current_field]);
        $this->current_field = $new_name;

        return $this->setFormElementAttribute('field_name', $new_name);
    }



    protected function withType(string $type)
    {
        return $this->setFormElementAttribute('type', $type);
    }



    /**
     * @param string $label
     *
     * @return $this
     */
    protected function withLabel(string $label)
    {
        $label = $this->replaceTrans($label);
        return $this->setFormElementAttribute('label', $label);
    }



    /**
     * @param string $hint
     *
     * @return $this
     */
    protected function withHint(string $hint)
    {
        $hint = $this->replaceTrans($hint);
        return $this->setFormElementAttribute('hint', $hint);
    }



    /**
     * @param string $rule
     *
     * @return $this
     */
    protected function withPurificationRule(string $rule)
    {
        return $this->setFormElementAttribute('purification_rules', $rule);
    }



    /**
     * @param string $rule
     *
     * @return $this
     */
    protected function withValidationRule(string $rule)
    {
        return $this->setFormElementAttribute('validation_rules', $rule);
    }



    /**
     * @param string $extra
     *
     * @return $this
     */
    public function withExtra(string $extra)
    {
        return $this->setFormElementAttribute('extra', $extra);
    }



    /**
     * @param string $class_list
     *
     * @return $this
     */
    public function withClass(string $class_list)
    {
        return $this->setFormElementAttribute('class', $class_list);
    }



    /**
     * @param string $style_list
     *
     * @return $this
     */
    public function withStyle(string $style_list)
    {
        return $this->setFormElementAttribute('style', $style_list);
    }



    public function whichIsRequired()
    {
        return $this->setFormElementAttribute('is_required', 'yes');
    }



    public function whichIsNotRequired()
    {
        return $this->setFormElementAttribute('is_required', 'no');
    }



    /**
     * @param string $slug
     *
     * @return $this
     */
    protected function placedAfter(string $slug)
    {
        $pointer          = 0;
        $discovered_order = 0;
        $form_items       = $this->orderFormItems();

        foreach ($form_items as $key => $item) {
            $pointer++;

            if ($discovered_order) {
                $form_items[$key]['order'] = $pointer + 1;
            } else {
                $form_items[$key]['order'] = $pointer;
            }

            if ($slug == $key) {
                $discovered_order = $pointer + 1;
            }
        }

        $this->form_items = $form_items;
        return $this->setFormElementAttribute('order', $discovered_order ? $discovered_order : $pointer);
    }



    /**
     * @param string $slug
     *
     * @return $this
     */
    protected function placedBefore(string $slug)
    {
        $pointer          = 0;
        $discovered_order = 0;
        $form_items       = $this->orderFormItems();

        foreach ($form_items as $key => $item) {
            $pointer++;

            if ($slug == $key) {
                $discovered_order = $pointer;
            }

            if ($discovered_order) {
                $form_items[$key]['order'] = $pointer + 1;
            } else {
                $form_items[$key]['order'] = $pointer;
            }
        }

        $this->form_items = $form_items;
        return $this->setFormElementAttribute('order', $discovered_order ? $discovered_order : $pointer);
    }



    /**
     * @param string $string
     *
     * @return string
     */
    private function replaceTrans(string $string)
    {
        $string = str_after(str_after($string, "trans:"), "tr:");

        return trans($string);
    }



    /**
     * @param string $attribute
     * @param string $matter
     *
     * @return $this
     */
    private function setFormElementAttribute(string $attribute, string $matter)
    {
        $this->form_items[$this->current_field][$attribute] = $matter;
        return $this;
    }



    /**
     * @return array
     */
    public function listFormItemMethods()
    {
        $methods = $this->methodsArray('FormItems');
        $result  = [];

        foreach ($methods as $method) {
            if (not_in_array($method, ['renderFormItems', 'loadFormItems'])) {
                $result[] = $method;
            }
        }

        return $result;
    }



    /**
     * @return array
     */
    public function renderFormItems()
    {
        $this->loadFormItems();
        $this->renderAutomaticAttributes();
        return $this->orderFormItems();
    }



    /**
     * @return array
     */
    private function orderFormItems()
    {
        return array_sort($this->form_items, function ($value) {
            return $value['order'];
        });
    }



    /**
     *
     */
    private function renderAutomaticAttributes()
    {
        foreach ($this->form_items as $key => $item) {
            $this->renderRequirement($key);
        }
    }



    /**
     * @param $key
     */
    private function renderRequirement($key)
    {
        $matter = $this->form_items[$key]['is_required'];

        if ($matter == 'yes') {
            $this->form_items[$key]['class'] .= " form-required ";
            $this->form_items[$key]['validation_rules'] .= " | required ";
            $this->form_items[$key]['is_required'] = true;
        } elseif ($matter == 'no') {
            str_replace('form-required', null, $this->form_items[$key]['class']);
            str_replace('required', null, $this->form_items[$key]['validation_rules']);
            $this->form_items[$key]['is_required'] = false;
        }
    }
}
