@php
	$html_prefix = 'html-';
	$filtered_keys = array_filter(array_keys($asset), function($key) use ($html_prefix) {
		return (is_string($key) and starts_with($key, $html_prefix));
	});
	$filtered = array_intersect_key($asset, array_flip($filtered_keys));
	$attributes = [];
	foreach ($filtered as $key => $value) {
		$attr_name = str_after($key, $html_prefix);
		$attributes[$attr_name] = $value;
	}
@endphp

@if(str_contains($asset['link'], '.js'))
	{!! Html::script (Module::asset($asset['link']), $attributes) !!}
@elseif(str_contains($asset['link'], '.css'))
	{!! Html::style(Module::asset($asset['link']), $attributes) !!}
@endif
