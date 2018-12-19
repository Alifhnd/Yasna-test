<span id = "{{ $id }}-wrapper">
<pdatepicker
			id = "{{ $id }}"
			name="{{ $name or "" }}"
			input-class="form-control {{ $class or "" }}"
			pdate-style="{{ $style or ""}}"

			@isset($placeholder_from)
			:placeholder-from="'{{ $placeholder_from }}'"
			@endisset

			@isset($placeholder_to)
			:placeholder-to="'{{ $placeholder_to }}'"
			@endisset

			@isset($value_from)
			value-from="{{ $value_from }}"
			@endisset

			@isset($value_to)
			value-to="{{ $value_to }}"
			@endisset

			@isset($on_change)
			onkeyup="{{ $on_change }}"
			@endisset

			@isset($on_blur)
			onblur="{{ $on_blur }}"
			@endisset

			@isset($on_focus)
			onfocus="{{ $on_focus }}"
			@endisset

			@isset($format)
			format="{{ $format }}"
			@endisset

			@isset($value_type)
			initial-value="{{ $value_type}}"
			@endisset

			@isset($calendar_type)
			calendar-type="{{ $calendar_type}}"
			@endisset

			@isset($only_time_picker)
			:only-time-picker="{{ $only_time_picker }}"
			@endisset

			@isset($calendar_switch)
			:calendar-switch="{{ $calendar_switch }}"
			@endisset

			@isset($scroll)
			:scroll="{{ $scroll }}"
			@endisset

			@isset($max)
			:pdate-max="{{ $max }}"
			@endisset

			@isset($min)
			:pdate-min="{{ $min }}"
			@endisset

			@isset($time_picker)
			:time-picker="{{ $time_picker }}"
			@endisset

			@isset($range)
			:range="{{ $range }}"
			@endisset
></pdatepicker>
	<input type="hidden" class="js" value="initPersianDatePicker('{{ $id }}-wrapper')">
</span>

