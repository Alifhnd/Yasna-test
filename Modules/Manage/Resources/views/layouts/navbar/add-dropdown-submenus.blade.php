@php
	$link = str_random(15);
@endphp
<a href="{{ $option['link'] or "#" }}" class="list-group-item" data-toggle="collapse">
	<div class="media-box">
		<div class="pull-left">
			<em class="fa fa-{{ $option['icon'] or ""}} fa-2x text-{{ $option['color'] or ""}}"></em>
		</div>
		<div class="media-box-body clearfix">
			<p class="mv5">{{ $option['caption'] or ""}}</p>
		</div>
	</div>
</a>
