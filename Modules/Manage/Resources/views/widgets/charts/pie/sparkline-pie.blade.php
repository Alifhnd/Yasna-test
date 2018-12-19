{{--
---- Sparkline Pie Chart blade and setup.
---- Input: color (Array of colors), height (number),
---- values (string of comma separated numbers)
---- class and id are optional
--}}

<div
        data-sparkline=""
        data-type="pie"
        data-slice-colors="{{ $color or "" }}"
        data-height="{{ $height or "" }}"
        values="{{ $values or ''}}"
        class="{{ $class or "" }}"
        id="{{ $id or "" }}"
></div>