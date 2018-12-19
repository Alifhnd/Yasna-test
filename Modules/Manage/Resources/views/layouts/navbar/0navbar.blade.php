<!-- top navbar-->
<header class="topnavbar-wrapper">
    <!-- START Top Navbar-->
    <nav role="navigation" class="navbar topnavbar">
        <!-- START navbar header-->
        @include('manage::layouts.navbar.navbar-header')
        <!-- END navbar header-->
        <!-- START Nav wrapper-->
        @include('manage::layouts.navbar.nav-wrapper')
        <!-- END Nav wrapper-->
        <!-- START Search form-->
        @include('manage::layouts.navbar.search')
        <!-- END Search form-->
        <!-- START alert-->
        @include('manage::layouts.popup')
        <!-- END alert-->
    </nav>
    <!-- END Top Navbar-->
</header>

