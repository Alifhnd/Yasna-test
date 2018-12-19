@php
	module('manage')->service('nav_create_handler')->handle();
	$options = module('manage')->service('nav_create')->read();
@endphp

@if(count($options))
	<a href="#" data-toggle="dropdown">
		<em class="icon-plus"></em>
	</a>

	@include('manage::layouts.navbar.add-dropdown')
@endif