@extends('manage::layouts.template')

@php
	$ticket_owner_id = $ticket['owner_id'];
@endphp

@section('content')
	<div class="tickets-timeline">

		{{-- Ticket header --}}
		@include('manage::support.single.header')

		<ul class="timeline">
			@include('manage::support.single.dialog-box',[
					"owner_id" => $ticket['owner_id'] ,
					"badge_type" => $ticket['type'] ,
					"author" => $ticket['owner_name']  ,
					"time" => $ticket['created_at'] ,
					"content" => [
						"type" => $ticket['type'] ,
						"title" => $ticket['title'] ,
						"attachments" => $ticket['attachments'] ,
						"body" => $ticket['text'] ,
					],
				])
			{{-- DO NOT REMOVE THIS--}}
			<li style="display: block; width: 100%; visibility: hidden;"></li>

			@foreach($timeline as $data)
				@include('manage::support.single.dialog-box',[
					"owner_id" => $data['owner_id'] ,
					"badge_type" => $data['type'] ,
					"author" => $data['owner_name'],
					"time" => $data['created_at'] ,
					"content" => [
						"type" => $data['type'] ,
						"title" => $data['title'] ,
						"attachments" => $data['attachments'] ,
						"body" => $data['text'] ,
					],
					"flag" => $data['flag'] ,
				])

				{{-- DO NOT REMOVE THIS--}}
				<li style="display: block; width: 100%; visibility: hidden;"></li>

			@endforeach

			@if($ticket['flag'] === "done")
				<li class="timeline-end">
					<div class="timeline-badge danger">
						<em class="fas fa-ban" style="line-height: 35px;"></em>
					</div>
				</li>
			@else
				@include('manage::support.single.dialog-box',[
					"owner_id" => $ticket['owner_id'] ,
					"reversed" => false,
					"id" => "timeline_comment_box" ,
					"badge_type" => "editor" ,
					"author" => $ticket['owner_name']  ,
					"time" => "" ,
					"content" => [
						"type" => 'editor' ,
					] ,
					"form_action" => route('manage.support.reply', [
						'type' => $ticket_type['slug'],
						'hashid' => $ticket['id']
					])
				])

				<li class="timeline-end">
					<div class="timeline-badge">
						<em class="fas fa-ellipsis-v" style="line-height: 35px;"></em>
					</div>
				</li>
			@endif


		<!-- END timeline item-->
		</ul>

	</div>


@endsection
