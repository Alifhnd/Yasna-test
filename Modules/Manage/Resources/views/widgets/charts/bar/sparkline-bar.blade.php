{{--
---- Sparkline bar Chart blade and setup.
---- Input: color (rgb or hex), height (number), barWidth (number), barSpacing (number),
---- values (string of comma separated numbers)
---- class and id are optional
--}}

<div
        data-sparkline=""
        data-bar-color="{{ $color or "" }}"
        data-height="{{ $height or "" }}"
        data-bar-width="{{ $barWidth or '' }}"
        data-bar-spacing="{{ $barSpacing or '' }}"
        data-values="{{ $values or ''}}"
        class="{{ $class or "" }}"
        id="{{ $id or "" }}"
></div>