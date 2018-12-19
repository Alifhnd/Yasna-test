<div class="p">
    <h4 class="text-muted text-thin font-yekan">{{ $title }}</h4>
    <div class="table-grid mb">
        @foreach( $lightThemes as $theme )
            @include('manage::layouts.off-sidebar.theme-icon')
        @endforeach

    </div>
    <div class="table-grid mb">
        @foreach( $darkThemes as $theme )
            @include('manage::layouts.off-sidebar.theme-icon')
        @endforeach
    </div>
</div>

<div class="noDisplay">
    <button id="btnThemeSaved" data-notify="" data-message="{{ trans_safe("manage::template.theme_saved") }}" data-options='{"status":"success"}'></button>
    <button id="btnThemeNotSaved" data-notify="" data-message="{{ trans_safe("manage::template.theme_not_saved") }}" data-options='{"status":"danger"}'></button>
</div>