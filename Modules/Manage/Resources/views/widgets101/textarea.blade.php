<textarea
		id="{{ $id }}"
		name="{{ $name }}"
		class="form-control {{ $class }}"
		placeholder="{{ $placeholder }}"
		rows="{{ $rows }}"
		style="resize: vertical; {{ $style }}"
		dir="auto"
		@if($disabled)
			disabled="disabled"
		@endif

		{{ $extra }}
>{{ $value }}</textarea>

@if($help)
	<span class="help-block {{ $help_class }}" style="{{ $help_style }}" onclick="{{ $help_click }}">
			{{ $help }}
		</span>
@endif
