<a
		id="{{ $id }}"
		type="{{ $type }}"
		name="{{ $name }}"
		href="{{ $target }}"
		class="{{ $class }} "
		style="{{ $style }}"
		onclick="{{$on_click}}"
		target="{{ $new_window }}"

		@if($disabled)
			disabled="disabled"
		@endif

		{{ $extra }}
>
	@if($icon)
		<i class="fa fa-{{$icon}}"></i>
	@endif
	{{ $label }}
</a>
