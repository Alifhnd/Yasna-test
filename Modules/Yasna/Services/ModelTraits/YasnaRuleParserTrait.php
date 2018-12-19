<?php

namespace Modules\Yasna\Services\ModelTraits;

trait YasnaRuleParserTrait
{
    /**
     * get meta fields related to the rules system
     *
     * @return array
     */
    public function rulesMetaFields()
    {
        return [
             $this->getRuleParserMetaName(),
        ];
    }



    /**
     * get rules array
     *
     * @return array
     */
    public function getRules(): array
    {
        return (array)$this->getMeta('rules');
    }



    /**
     * get a single rule by its identifier
     *
     * @param string $identifier
     *
     * @return array
     */
    public function getRule(string $identifier): array
    {
        return $this->getRules()[$identifier];
    }



    /**
     * get a single-layer array of the rule titles
     *
     * @return array
     */
    public function getRuleTitles()
    {
        $array = [];

        foreach ($this->getRules() as $rule) {
            $class   = $rule['_class'];
            $array[] = $class::getTitle();
        }

        return $array;
    }



    /**
     * get the number of registered rules
     *
     * @return int
     */
    public function rulesCount()
    {
        return count($this->getRules());
    }



    /**
     * add new rule to the model object (without saving into the database)
     *
     * @param string $class
     * @param array  $values
     *
     * @return array
     */
    public function addRule(string $class, array $values): array
    {
        $rules              = $this->getRules();
        $identifier         = str_random(10) . time();
        $values['_class']   = $class;
        $rules[$identifier] = $values;

        $this->setMeta("rules", $rules);

        return $this->getRules();
    }



    /**
     * remove an existing rule from the model object by its identifier (without saving into the database)
     *
     * @param string $identifier
     *
     * @return array
     */
    public function deleteRule(string $identifier): array
    {
        $rules = $this->getRules();
        unset($rules[$identifier]);

        $this->setMeta("rules", $rules);

        return $this->getRules();
    }



    /**
     * update the values of an existing rule on the model object by its identifier (without saving into the database)
     *
     * @param string $identifier
     * @param array  $values
     *
     * @return array
     */
    public function updateRule(string $identifier, array $values): array
    {
        $rules = $this->getRules();
        foreach ($values as $key => $value) {
            $rules[$identifier][$key] = $value;
        }

        $this->setMeta("rules", $rules);

        return $this->getRules();
    }



    /**
     * get titles meta name
     *
     * @return string
     */
    protected function getRuleParserMetaName()
    {
        return isset(static::$rule_parser_meta_field_name) ? static::$rule_parser_meta_field_name : "rules";
    }
}
