{{--TODO: Instead of manually adding the input, it is supposed to include `input-basic`. But that blade use `form-control` in the html class which makes trouble for the purpose of this module. Refactore this blade when that problem is solved.--}}

<input
		type="{{ $type }}"
		id="{{ $id }}"
		name="{{ $name }}"
		value="{{ $value }}"
		class="{{ $class }}"
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
>
@if($help)
	<span class="help-block {{ $help_class }}" style="{{ $help_style }}" onclick="{{ $help_click }}">
			{{ $help }}
		</span>
@endif



@include('manage::widgets101.selectize-js')