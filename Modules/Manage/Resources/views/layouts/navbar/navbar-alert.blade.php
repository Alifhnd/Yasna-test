{{--
|--------------------------------------------------------------------------
| Process
|--------------------------------------------------------------------------
|
--}}

@php
	module('manage')->service('nav_notification_handler')->handle();
	$notifications = module('manage')->service('nav_notification')->read();

	$totalCount = 0;
	foreach ($notifications as $notification){
		$totalCount += $notification['count'];
	}
@endphp

{{--
|--------------------------------------------------------------------------
| Show Notification Icon
|--------------------------------------------------------------------------
|
--}}

@if($totalCount)
	<a href="#" data-toggle="dropdown" ondblclick="notifReload()">
		<em class="icon-bell"></em>
		<div class="label label-danger">{{ pd($totalCount) }}</div>
	</a>
	@include('manage::layouts.navbar.navbar-alert-dropdown',[
		'notifications' => $notifications
	])
@endif


{{--
|--------------------------------------------------------------------------
| When No Notification is available
|--------------------------------------------------------------------------
|
--}}
@if(!$totalCount)
	<a href="#" data-toggle="dropdown" ondblclick="notifReload()">
		<em class="fa fa-bell-slash-o"></em>
	</a>
	@include('manage::layouts.navbar.navbar-alert-none')
@endif

{{--
|--------------------------------------------------------------------------
| Script
|--------------------------------------------------------------------------
|
--}}
<script>
	@if( $interval = intval( getSetting('notifications_intervals') ) )
		setTimeout( function() {
			notifReload();
		}, {{ $interval * 1000 }});
	@endif

	function notifReload()
	{
	    divReload('liNavbarAlert');
	}
</script>
