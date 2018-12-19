<ul class="nav">
    <!-- START user info-->
    @include('manage::layouts.sidebar.sidebar-userinfo')
    <!-- END user info-->
    <!-- Iterates over all sidebar items-->

    <!-- Sidebar heading -->
    {{--@include('manage::layouts.sidebar.sidebar-item-heading',[
        "heading" => "Main Navigation"
    ])--}}

    <!-- Sidebar items -->
    @include('manage::layouts.sidebar')

</ul>