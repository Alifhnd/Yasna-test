@php
	$link = manage()->parseLink($option['link']);
@endphp

<a href="{{ $link['href'] }}" onclick="{{ $link['js'] }}" target="{{ $link['target'] }}" class="list-group-item">
	<div class="media-box">
		<div class="pull-left">
			<em class="fa fa-{{ $option['icon'] or ""}} fa-2x text-{{ $option['color'] or ""}}"></em>
		</div>
		<div class="media-box-body clearfix">
			<p class="mv5">{{ $option['caption'] or ""}}</p>
		</div>
	</div>
</a>
