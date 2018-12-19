<?php

namespace Modules\Manage\Services;


class ManageDashboardWidget
{

    /**
     * Set default value for widgets
     *
     * @param string $widget
     * @param int    $width
     * @param int    $x
     * @param int    $y
     * @param bool   $condition
     */
    public static function addDefault($widget, $width, $x, $y, $condition = true)
    {
        $service = 'default_widgets';

        module('manage')
             ->service($service)
             ->add($widget)
             ->set('width', $width)
             ->set('x', $x)
             ->set('y', $y)
             ->condition($condition)
        ;
    }
}
