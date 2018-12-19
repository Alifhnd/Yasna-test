@if($addon)
	<div class="input-group {{ $group_class }}">
		@endif
		@include( widget()->viewPath('input-basic') , [
			'help' => null ,
		] )

		@if($addon)
			<span class="input-group-addon f10 {{ $addon_class }}"
				  onclick="{{ $addon_click }}">{{ $addon }}</span>

	</div>
@endif
@if($help)
	<span class="help-block {{ $help_class }}" style="{{ $help_style }}" onclick="{{ $help_click }}">
			{{ $help }}
		</span>
@endif

