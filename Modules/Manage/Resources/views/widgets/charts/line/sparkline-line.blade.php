{{--
---- Sparkline line Chart blade and setup.
---- Input: lineColor (hex or rgb), height (number or percent), width (number or percent), lineWidth (number),spotColor ( hex or rgb)
---- minColor (hex or rgb), maxColor (hex or rgb), fillColor (hex or rgb), highlightLine (hex or rgb), spotRad (number)
---- values (string of comma separated numbers)
---- class and id are optional
--}}

<div
        data-sparkline=""
        data-type="line"
        data-resize="true"
        data-line-color="{{ $lineColor or "" }}"
        data-spot-color="{{ $spotColor or "" }}"
        data-min-spot-color="{{ $minColor or "" }}"
        data-max-spot-color="{{ $maxColor or "" }}"
        data-fill-color="{{ $fillColor or "" }}"
        data-highlight-line-color="{{ $highlightLine or "" }}"
        data-spot-radius="{{ $spotRad or "" }}"
        data-height="{{ $height or "" }}"
        data-width="{{ $width or "" }}"
        data-line-width="{{ $lineWidth or "" }}"
        data-values="{{ $values or ''}}"
        class="{{ $class or "" }}"
        id="{{ $id or "" }}"
></div>