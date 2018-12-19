{{--
|--------------------------------------------------------------------------
| Hidden Safety Field
|--------------------------------------------------------------------------
|
--}}

@include( widget()->viewPath('hidden'))
<div class="wrapper {{ $container_class }}" onclick="{{ $on_change }}">
	{{--
	|--------------------------------------------------------------------------
	| Visible Toggle Button
	|--------------------------------------------------------------------------
	|
	--}}
	<input type="hidden" name="{{$name or ''}}" value="0">

	<input
			{{ (boolval($value))? 'checked' : ''}}
			id="{{ $id }}"
			placeholder="" {{-- <~~ Just to get rid of annyoying IDE error! --}}
			name="{{ $name }}"
			class="bootstrapToggle"
			type="checkbox"
			data-size="small"
			data-width="{{ $size }}"
			data-height="5"
			data-on="{{ $data_on }}"
			data-off="{{ $data_off }}"
			data-onstyle="{{ $data_on_style }}"
			data-offstyle="{{ $data_off_style }}"
			data-class="quick"

			@if($disabled)
			disabled="disabled"
			@endif

			{{ $extra }}
	>

	{{--
	|--------------------------------------------------------------------------
	| Label
	|--------------------------------------------------------------------------
	| if exists
	--}}

	@if($label)
		<label class="control-label ph10 {{ $label_class }}">
			{{ $label }}
		</label>
	@endif

</div>
