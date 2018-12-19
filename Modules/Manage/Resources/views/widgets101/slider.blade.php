<input
        data-ui-slider=""
        type="text"
        value=""
        data-slider-min="{{ $min }}"
        data-slider-max="{{ $max }}"
        data-slider-step="{{ $step }}"
        data-slider-value="{{ $value }}"
        onkeyup="{{ $on_change }}"
        onblur="{{ $on_blur }}"
        onfocus="{{ $on_focus }}"
        title="{{ $tooltip }}"
        data-slider-orientation="horizontal"
        class="slider slider-horizontal"
        @if($disabled)
        disabled="disabled"
        @endif
        {{ $extra }}
>