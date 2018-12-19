<div id="{{ $container_id }}" class="checkbox c-checkbox {{ $container_class }}">
	<label title="{{ $help }}" class="{{ $label_class }}" style="{{ $label_style }}">
		<input type="hidden" name="{{ $name }}" value="0">

		<input
				type="checkbox"
				value="1"
				id="{{ $id }}"
				class="{{$class}}"
				name="{{$name}}"
				{{ $disabled? "disabled" : "" }}
				{{ $value? "checked=checked" : '' }}
				{{ $extra }}
				onclick="{{$on_click}}"
				onchange="{{$on_change}}"
		>
		<span class="fa fa-check"></span>
		{{ $help }}
	</label>
</div>
