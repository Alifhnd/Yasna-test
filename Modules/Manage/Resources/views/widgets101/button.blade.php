<button
		id="{{ $id }}"
		type="{{ $type }}"
		name="{{ $name }}"
		value="{{ $value }}"
		class="{{ $class }} "
		style="{{ $style }}"
		onclick="{{$on_click}}"

		@if($disabled)
			disabled="disabled"
		@endif

		{{ $extra }}
>
	@if($icon)
		<i class="fa fa-{{$icon}}"></i>
	@endif
	{{ $label }}
</button>
