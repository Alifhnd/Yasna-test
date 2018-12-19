<input
		type="{{ $type }}"
		id="{{ $id }}"
		name="{{ $name }}"
		value="{{ $value }}"
		class="form-control {{ $class }}"
		style="{{ $style }}"
		placeholder="{{ $placeholder }}"
		onkeyup="{{ $on_change }}"
		onblur="{{ $on_blur }}"
		onfocus="{{ $on_focus }}"
		aria-valuenow="{{ $value }}"
		title="{{ $tooltip }}"
		@if($disabled)
			disabled="disabled"
		@endif
		{{ $extra }}
		dir="auto"
		autocomplete="{{ $auto_complete }}"
>
@if($help)
	<span class="help-block {{ $help_class }}" style="{{ $help_style }}" onclick="{{ $help_click }}">
			{{ $help }}
		</span>
@endif
