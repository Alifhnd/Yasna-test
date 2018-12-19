<ul class="dropdown-menu animated flipInX">
    <li>
        <!-- START list group-->
        <div class="list-group">

            @foreach( $notifications as $notification)
                @include("manage::layouts.navbar.navbar-alert-link")
            @endforeach

        </div>
    </li>
</ul>