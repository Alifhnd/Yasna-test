<img
        {{--src="{{ str_contains($src , ':')?  Module::asset($src) : $src }}"--}}
        src="{{ $src }}"
        alt="{{ $alt or "" }}"
        class="{{ $class or "" }}"
        id="{{ $id or "" }}"
        width="{{ $width or "" }}"
        height="{{ $height or "" }}"
        style="{{ $style or "" }}"
        {{ $extra or "" }}
>