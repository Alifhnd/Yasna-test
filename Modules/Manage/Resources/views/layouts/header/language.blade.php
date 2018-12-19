<div class="pull-right">
    <div class="btn-group">
        @include('manage::forms.button',[
            "class"=>"",
            "extra"=>"data-toggle=dropdown",
            "label"=>"English"
        ])
        <ul role="menu" class="dropdown-menu dropdown-menu-right animated fadeInUpShort">
            <li><a href="#" data-set-lang="en">English</a>
            </li>
            <li><a href="#" data-set-lang="es">Spanish</a>
            </li>
        </ul>
    </div>
</div>