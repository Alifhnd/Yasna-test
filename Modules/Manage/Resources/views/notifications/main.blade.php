@extends('manage::layouts.template')

@section('content')
	@php $any_notification = boolval($notifications->count()) @endphp

	<div class="panel panel-default notifications-pane notifications-page">
		<div class="panel-heading clearfix">
			<h4 class="pull-left m0">
				{{ trans('manage::notifications.title') }}
			</h4>

			{!!
				widget('button')
					->class('btn-xs pull-right js_markAll icon-sm')
					->shape('primary')
					->label('tr:manage::notifications.mark_all')
					->icon('check')
					->condition($any_notification)
			 !!}
		</div>

		<div class="panel-body p0">
			@if ($any_notification)
				@foreach($notifications as $notification)
					@php $group = databaseNotification()->getNotificationGroup($notification) @endphp
					@include('manage::notifications.notifications-item', [
						"class" => "p-lg" ,
						"id" => $notification->id ,
						"link" => databaseNotification()->getNotificationUrl($notification) ,
						"is_read" => $notification->read() ,
						"title" => $notification->data['content'] ?? '' ,
						"date" => ad(echoDate($notification->created_at, 'j F Y - H:i')),
						"content" => $notification->data['message'] ?? null ,
						"color" =>  $group->getColor() ,
						"icon" => $group->getIcon() ,
					])
				@endforeach

				<div class="col-sm-12 text-center">
					{!! $notifications->render() !!}
				</div>
			@else
				@include($__module->getBladePath('notifications.notification-empty'))
			@endif

		</div>

	</div>

@stop
