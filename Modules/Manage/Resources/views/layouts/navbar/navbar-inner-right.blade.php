@php
	//	max-height of notification and add dropdown
	$visibleCount= 6;
	$list_max_height= $visibleCount * 53 + 2;
@endphp

<ul class="nav navbar-nav navbar-right">

	<li class="notification">
		@include($__module->getBladePath('layouts.navbar.navbar-inner-right-notification'))
	</li>

	<li class="dropdown dropdown-list">
		@include('manage::layouts.navbar.add')
	</li>

	<li class="visible-lg">

		@include('manage::layouts.link-icon',[
			"href" => "#",
			"extra"=>"data-toggle-fullscreen=",
			"icon"=>"fa fa-expand"
		])
	</li>


	<li>
		@include('manage::layouts.link-icon',[
			"href" => "#",
			"class" => "prevented" ,
			"extra"=>"data-toggle-state=offsidebar-open  data-no-persist=true",
			"icon"=>"icon-notebook"
		])

	</li>

</ul>
