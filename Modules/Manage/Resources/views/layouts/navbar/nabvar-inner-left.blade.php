<ul class="nav navbar-nav">
    <li>
        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
        @include('manage::layouts.link-icon',[
            "href"=>"#",
            "class"=> "hidden-xs prevented",
            "extra"=>'data-trigger-resize="" data-toggle-state=aside-collapsed',
            "icon" => "fa fa-navicon",
            'id' => "lnkSidebarCollapse" ,
        ])

        <!-- Button to show/hide the sidebar on mobile. Visible on mobile only.-->
        @include('manage::layouts.link-icon',[
            "href"=>"#",
            "class"=> "visible-xs sidebar-toggle prevented",
            "extra"=>'data-toggle-state=aside-toggled data-no-persist=true',
            "icon" => "fa fa-navicon" ,
        ])
    </li>
    <!-- START User avatar toggle-->
    <li>
        <!-- Button used to collapse the left sidebar. Only visible on tablet and desktops-->
        @include('manage::layouts.link-icon',[
            "href"=>"#user-block",
            "id"=> "user-block-toggle",
            "class" => "prevented",
            "extra"=>'data-toggle=collapse',
            "icon" => "icon-user"
        ])
    </li>
    <!-- END User avatar toggle-->
    <!-- START lock screen-->
    {{-- Not ready to use --}}
    {{--<li>
        @include('manage::layouts.link-icon',[
            "href"=> $lockUrl,
            "extra"=>'title=Lock screen',
            "icon" => "icon-lock"
        ])

    </li>--}}
    <!-- END lock screen-->
</ul>