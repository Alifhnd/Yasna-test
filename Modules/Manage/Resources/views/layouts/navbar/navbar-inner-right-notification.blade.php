@php $notifications_count = user()->unreadNotifications()->count(); @endphp

<a href="#">
	@if ($notifications_count)
		<em class="icon-bell"></em>
		<div class="label label-danger">{{ pd($notifications_count) }}</div>
	@else
		<em class="fa fa-bell-slash-o"></em>
	@endif
</a>
