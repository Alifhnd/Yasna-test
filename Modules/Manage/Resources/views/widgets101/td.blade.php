<td id="{{ $id }}" class="{{ $class }}" style="{{ $style }}">

	@if($blade)
		@include($blade)
	@else
		{{ $label }}
	@endif

</td>