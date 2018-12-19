<a href="{{ $link }}" data-id="{{ $id }}" class="notification-item mt0 clearfix {{ ($is_read)? "read" : "" }} {{ $class or "" }}">

	<!-- Contact info-->
	<div class="media-box">

		<div class="pull-left notifications-icon bg-{{ $color}}">
			<em class="fa fa-{{ $icon }} text-white"></em>
		</div>

		<div class="media-box-body clearfix">
			<div class="title">{{ $title }}</div>
			<small class="text-muted">{{ $date }}</small>

			@if(isset($content) and $content)
				<div class="mv">
					{{ $content }}
				</div>
			@endif
		</div>
	</div>
</a>
