@if(0)
	<div>
		<div>
			<div>
				@endif

				@if(!isset($no_form) or !$no_form)
					@include('manage::forms.closer')
					{!! Html::script (Module::asset("manage:libs/tinymce/tinymce.starter.js")) !!}
				@endif
			</div>
		</div>
	</div>
