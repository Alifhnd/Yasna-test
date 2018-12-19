@if($type!='stop')
	@if($separated)
		@include( widget()->viewPath( 'separator' ))
	@endif
	<div id="{{ $container_id }}" class="form-group {{ $container_class }}"
		 style="{{ $container_style }}" {{ $container_extra }}>

		{{--
		|--------------------------------------------------------------------------
		| Label
		|--------------------------------------------------------------------------
		|
		--}}

		<label for="{{ $name }}" class="col-sm-2 control-label {{ $label_class }}">
			{{ $label }}

			@if($required)
				<span class="fa fa-star required-sign " title="{{trans('manage::forms.logic.required')}}"></span>
			@endif

		</label>


		{{--
		|--------------------------------------------------------------------------
		| Group
		|--------------------------------------------------------------------------
		|
		--}}
		<div class="col-sm-10">
			@endif
			@if($inside_blade)
				@include( widget()->viewPath( $inside_blade ))
			@endif
			@if( $type == 'stop' or $inside_blade )
		</div>


	</div>
@endif