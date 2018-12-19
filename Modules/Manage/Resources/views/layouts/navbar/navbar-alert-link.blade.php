@php
	$link = manage()->parseLink($notification['link']);
@endphp

@if($notification['count'] > 0)
	<a href="{{ $link['href'] }}" onclick="{{ $link['js'] }}" target="{{ $link['target'] }}" class="list-group-item">
		<div class="media-box">
			<div class="pull-left">
				<em class="fa fa-{{ $notification['icon'] }} fa-2x text-{{ $notification['color'] }}"></em>
			</div>
			<div class="media-box-body clearfix">
				<p class="m0">{{ $notification['caption'] }}</p>
				<p class="m0 text-muted">
					<small>{{ pd($notification['count'])." ".$notification['comment'] }}</small>
				</p>
			</div>
		</div>
	</a>
@endif
