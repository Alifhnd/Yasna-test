<ul class="dropdown-menu animated flipInX add-menu"
    @if(isset($list_max_height))
    style=" max-height: {{ $list_max_height . "px"}};
            overflow-y: auto;"
    @endif
>
    @foreach( $options as $option)
        <li>

            @if(isset($option['sub_menus']))
                @include("manage::layouts.navbar.add-dropdown-submenus")
            @else
                @include("manage::layouts.navbar.add-link")
            @endif

        </li>
    @endforeach
</ul>