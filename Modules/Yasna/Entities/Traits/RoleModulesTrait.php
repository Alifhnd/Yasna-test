<?php

namespace Modules\Yasna\Entities\Traits;

/**
 * Trait RoleModulesTrait, attached to Role
 * Responsible to house methods relative to the `modules` field
 *
 * @property string $modules
 * @property bool   $is_admin
 */
trait RoleModulesTrait
{
    /**
     * get the minimum status of which the holder user will be considered as 'active'
     *
     * @return int
     */
    public function minActiveStatus(): int
    {
        return (int)$this->getMeta("min_active_status");
    }



    /**
     * check if the current role has sub-permission system
     *
     * @return bool
     */
    public function isPrivileged(): bool
    {
        return boolval($this->getMeta("is_privileged")) or $this->hasModules() or boolval($this->is_admin);
    }



    /**
     * check if the current role has not sub-permission system
     *
     * @return bool
     */
    public function isNotPrivileged(): bool
    {
        return !$this->isPrivileged();
    }



    /**
     * check if modules are defined for the role.
     *
     * @return bool
     */
    public function hasModules(): bool
    {
        return (bool)count($this->modulesArray());
    }



    /**
     * check if modules are not defined for the role.
     *
     * @return bool
     */
    public function hasnotModules()
    {
        return !$this->hasModules();
    }



    /**
     * check if the current role has sub-permission system
     *
     * @deprecated
     * @return bool
     */
    public function getHasModulesAttribute()
    {
        return $this->hasModules();
    }



    /**
     * get the sub-modules array
     *
     * @return array
     */
    public function modulesArray()
    {
        if (!is_json($this->modules)) {
            return [];
        }

        return json_decode($this->modules, true);
    }



    /**
     * get the sub-modules array
     *
     * @deprecated
     * @return array
     */
    public function getModulesArrayAttribute()
    {
        return $this->modulesArray();
    }



    /**
     * get a string of modules and permissions, suitable to be shown in the text input field.
     *
     * @return string
     */
    public function modulesArrayForTextInput(): string
    {
        $string = "";

        foreach ($this->modulesArray() as $module => $permits) {
            if ($string) {
                $string .= HTML_LINE_BREAK;
            }

            $string .= "$module: ";
            foreach ($permits as $permit) {
                $string .= " $permit , ";
            }
        }

        return $string;
    }



    /**
     * convert user input into a standard json entry to be saved in the db.
     *
     * @param string $user_input
     *
     * @return string
     */
    public function convertModulesInputToJson(string $user_input): string
    {
        $array_layer_1 = array_filter(preg_split("/\\r\\n|\\r|\\n/", $user_input));
        $array_final   = [];

        foreach ($array_layer_1 as $item) {
            $array_layer_2     = array_filter(explode(':', str_replace(' ', null, $item)));
            $key               = $array_layer_2[0];
            $array_final[$key] = array_filter(explode(',', str_replace(' ', null, $array_layer_2[1])));
        }

        $json = json_encode($array_final);

        return $json;
    }
}
