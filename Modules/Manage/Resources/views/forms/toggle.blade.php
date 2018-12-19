@if(!isset($condition) or $condition)
	@php
		isset($in_form) ?: $in_form = false;
	@endphp

	@if(!isset($label))
		{{ null , $label = Lang::has("validation.attributes.$name") ? trans("validation.attributes.$name") : $name}}
	@endif

	@if($in_form)
		<div id="div-{{$id or ''}}" class="form-group">
			<div class="col-sm-2 text-right">
	@endif

		<input type="hidden" name="{{$name or ''}}" value="0">
		<input {{ (isset($value) and $value)? 'checked' : ''}}
			   id="{{$id or ''}}"
			   name="{{$name or ''}}"
			   class="bootstrapToggle"
			   type="checkbox"
			   data-size="small"
			   data-width="{{$data_width or 50}}"
			   data-height="5"
			   data-on="{{$data_on or "<i class='fa fa-check'>" }}"
			   data-off="{{ $data_off or "<i class='fa fa-times'>" }}"
			   data-onstyle="{{ $data_on_style or 'primary' }}"
			   data-offstyle="{{ $data_off_style or 'default' }}"
			   data-class="quick"
				{{ (isset($disabled) and $disabled) ? "disabled"  : ''}}
		>

	@if($in_form)
		</div>
		<div class="col-sm-10 {{$div_class or ''}}">
	@endif


		<label class="control-label ph10 {{$label_class or ''}}">
			{{ $label }}
		</label>

	@if($in_form)
		</div>
		</div>
	@endif

@endif
