<?php
namespace Modules\Yasna\Providers;

use Nwidart\Modules\Facades\Module;

trait YasnaTrait
{
    public static function subModules($include_self = false)
    {
        $result = [] ;
        foreach (Module::enabled() as $module) {
            if (in_array('Yasna', $module->getRequires()) or ($include_self and $module->getName()=='Yasna')) {
                $result[] = $module->name;
            }
        }

        return $result ;
    }

    public static function familyModules()
    {
        return self::subModules(true);
    }
}
