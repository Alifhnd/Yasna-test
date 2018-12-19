<div id="{{ $container_id }}" class="{{ $container_class }}" {{ $container_extra }}>
	<label for="{{ $name }}" class="control-label text-gray {{ $label_class }}"
		   style="margin-top:10px;{{ $label_style }}">{{ $label }}...</label>

	@include(  widget()->viewPath('persian-datepicker') )
</div>