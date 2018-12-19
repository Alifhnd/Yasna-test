{!!
    widget('Modal')
    ->label('tr:users::profile.title')
!!}

@php $profile = userProfile($model) @endphp

<div class="modal-body user-profile">
	<div class="panel b widget">
		<div class="bg-info gradient half-float p-xl">
			<div class="header"></div>

			<div class="half-float-bottom">
				<img src="{{ $profile->getAvatar() }}" alt="Image" class="img-thumbnail img-circle">
			</div>
		</div>

		<div class="pt-sm user-title">
			<h4>
				{{ $profile->getNameString() }}
			</h4>

			@php $identifier = $profile->getIdentifier() @endphp
			@isset($identifier)
				<div class="text-muted">
					{!! $identifier !!}
				</div>
			@endisset
		</div>

		<div class="panel-body pt-xl">

			<div class="mv40">
				@php $rows = $profile->getRows() @endphp
				@foreach($rows as $row)
					@include('users::profile.widgets.data-row',[
						"title" => $row['title'] ,
						"value" => $row['value'] ,
					])
				@endforeach
			</div>

		</div>

		@php $extra_blades = $profile->getBlades() @endphp
		@foreach($extra_blades as $blade)
			@include($blade, ['model' => $model])
		@endforeach

	</div>

</div>

<div class="modal-footer">
	@php $is_demo = ($is_demo ?? false) @endphp
	{!!
		widget('button')
			->label('tr:users::profile.view_demo')
			->class('btn-outline')
			->shape('info')
			->condition(user()->isDeveloper())
			->onClick('masterModal("'. route('user-profile-demo') .'")')
	!!}

	@foreach ($profile->getButtons() as $button)
		{!! $button !!}
	@endforeach
</div>
