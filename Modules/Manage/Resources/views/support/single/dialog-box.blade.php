<!-- START timeline item-->
@php
	$dialog_type = [
		"default" => [
			"color" => "primary" ,
			"icon" => "comments" ,
		] ,
		"changing-flag" => [
			"color" => "warning" ,
			"icon" => "exchange" ,
		] ,
		"editor" => [
			"color" => "info" ,
			"icon" => "pencil" ,
		] ,
	];
	$badge = $dialog_type[$badge_type];
@endphp
<li class="timeline-inverted" id="{{ $id or "" }}">
	<div class="timeline-badge {{ $badge['color'] or "primary" }}">
		<em class="fa fa-{{ $badge['icon'] or "comments" }}"
			style="line-height: 35px;"></em>
	</div>
	<div class="timeline-panel">
		<div class="popover right">
			<div class="popover-title">
				<div class="author">
					@if (!isset($owner_id) or ($ticket_owner_id == $owner_id))
						<img src="{{ Module::asset('manage:images/user/avatar-default.jpg') }}" class="img-thumbnail img-circle thumb32 mr-sm">
					@else
						<img src="{{ Module::asset('manage:images/user/support.png') }}" class="img-thumbnail img-circle thumb32 mr-sm">
					@endif
					<strong>{{ $author }}</strong>
					<small class="pull-right text-muted mt-sm">
						{{ ad(jDate::forge($time)->format('j F Y [H:i]')) }}
					</small>
				</div>
			</div>
			<div class="arrow"></div>
			<div class="popover-content">
				@if($content['type'] === "default")

					@include('manage::support.single.dialog-content',[
						"title" => $content['title'] ,
						"body" => $content['body'] ,
						"attached_files" => $content['attachments'] ,
						"labels" => $content['labels'] ?? null ,
					])

				@elseif($content['type'] === "changing-flag")

					<div class="text-bold pv">
						{{ trans("manage::support.flags.changing.$flag") }}
					</div>

				@elseif($content['type'] === "editor")

					@include('manage::support.single.editor')

				@endif
			</div>
		</div>
	</div>
</li>
<!-- END timeline item-->
