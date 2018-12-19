@php
	$notifications = user()->lastNotifications(10)->get();
	$any_notification = boolval($notifications->count());
@endphp

<div class="notifications-pane">
	<div class="clearfix mh mt-xl">
		<h3 class="text-thin pull-left mt0">
			{{ trans('manage::notifications.title') }}
		</h3>

		{!!
			widget('button')
				->class('btn-outline js_markAll btn-xs icon-sm pull-right')
				->shape('primary')
				->label('tr:manage::notifications.mark_all')
				->icon('check')
				->condition($any_notification)
		 !!}
	</div>

	@if ($any_notification)
		<ul class="nav mt-xl">
			@foreach(user()->lastNotifications(10)->get() as $notification)
				<li>
					@php $group = databaseNotification()->getNotificationGroup($notification) @endphp
					@include('manage::notifications.notifications-item', [
						"class" => "p" ,
						"id" => $notification->id ,
						"link" => databaseNotification()->getNotificationUrl($notification) ,
						"is_read" => $notification->read() ,
						"title" => $notification->data['content'] ?? '' ,
						"date" => ad(echoDate($notification->created_at, 'j F Y - H:i')),
						"color" =>  $group->getColor() ,
						"icon" => $group->getIcon() ,
					])
				</li>
			@endforeach

		</ul>
	@else
		@include($__module->getBladePath('notifications.notification-empty'))
	@endif

	<div class="text-center mv15">
		{!!
			widget('button')
				->label('tr:manage::notifications.more')
				->shape('purple')
				->target(route('notifications-list'))
				->condition($any_notification)
		 !!}
	</div>
</div>



