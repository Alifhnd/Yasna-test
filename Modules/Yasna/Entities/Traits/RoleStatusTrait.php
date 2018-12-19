<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait RoleModulesTrait, attached to Role
 * Responsible to house methods relative to the `status_rule` meta field
 */
trait RoleStatusTrait
{
    /**
     * gets the array of status rules
     *
     * @return array
     */
    public function statusRulesArray(): array
    {
        $array = $this->getMeta('status_rule');

        if (!is_array($array)) {
            return [];
        }

        return $array;
    }



    /**
     * make an accessor for $this->statusRulesArray()
     *
     * @deprecated (97/5/10)
     * @return array
     */
    public function getStatusRuleArrayAttribute()
    {
        return $this->statusRulesArray();
    }



    /**
     * check if status rules are defined for the role.
     *
     * @return bool
     */
    public function hasStatusRules(): bool
    {
        return boolval(count($this->statusRulesArray()));
    }



    /**
     * check if status rules are not defined for the role.
     *
     * @return bool
     */
    public function hasNotStatusRules(): bool
    {
        return $this->hasStatusRules();
    }



    /**
     * gets a json string of status rules
     *
     * @return string
     */
    public function statusRulesJson(): string
    {
        return json_encode($this->statusRulesArray());
    }



    /**
     * convert status code to status text, ready to be sent to trans system.
     *
     * @param string $status_code
     *
     * @return string
     */
    public function statusText($status_code): string
    {
        $array = $this->statusRulesArray();

        if (!count($array)) {
            return "active";
        }

        if (isset($array[$status_code])) {
            return $array[$status_code];
        }

        return $status_code;
    }



    /**
     * get a string of status rules, suitable to be shown in the text input field.
     *
     * @return string
     */
    public function statusRuleForTextInput(): string
    {
        $string = "";
        $array  = $this->statusRulesArray();

        foreach ($array as $status => $description) {
            if ($string) {
                $string .= HTML_LINE_BREAK;
            }

            $string .= "$status : $description";
        }

        return $string;
    }



    /**
     * convert user input into a standard json entry to be saved in the db.
     *
     * @param string $user_input
     *
     * @return array
     */
    public function convertStatusRulesToArray(string $user_input): array
    {
        $array_layer_1 = array_filter(preg_split("/\\r\\n|\\r|\\n/", $user_input));
        $array_final   = [];

        foreach ($array_layer_1 as $item) {
            $array_layer_2     = array_filter(explode(':', str_replace(' ', null, $item)));
            $key               = $array_layer_2[0];
            $array_final[$key] = $array_layer_2[1];
        }

        return $array_final;
    }
}
