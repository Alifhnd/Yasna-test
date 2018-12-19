

<div class="col mb">
    <div class="setting-color">
    @if($theme['name'] === $themeName)
            <label class="theme-label checked" data-load-css="{{ $theme['css'] or "" }}" data-name-css="{{ $theme['name'] }}">
    @else
            <label class="theme-label" data-load-css="{{ $theme['css'] or "" }}" data-name-css="{{ $theme['name'] }}">
    @endif

                <span class="icon-check"></span>

            <span class="split">
                <span class="color {{ $theme['color1'] or "" }}"></span>
                <span class="color {{ $theme['color2'] or "" }}"></span>
            </span>
            <span class="color {{ $theme['bgColor'] or "" }}"></span>
        </label>
    </div>
</div>