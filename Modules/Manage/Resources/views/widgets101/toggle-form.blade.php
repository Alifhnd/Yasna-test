<div id="{{ $container_id }}" class="form-group {{ $container_class }}"
	 style="{{ $container_style }}" {{ $container_extra }}>

	{{--
	|--------------------------------------------------------------------------
	| Toggle Switch
	|--------------------------------------------------------------------------
	| Label is unset
	--}}
	<div for="{{ $name }}" class="col-sm-2 control-label ">

		@include( widget()->viewPath('toggle') , [
			'label' => null ,
			'container_class' => null ,
		])

	</div>


	{{--
	|--------------------------------------------------------------------------
	| Label
	|--------------------------------------------------------------------------
	|
	--}}
	<div class="col-sm-10 pv5">
		<label class="control-label ph10 {{ $label_class }}">
			{{ $label }}
		</label>
	</div>

</div>