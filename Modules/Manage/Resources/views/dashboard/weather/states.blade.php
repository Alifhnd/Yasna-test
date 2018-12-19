{!! Widget('modal')->target(url('manage/weather/update_state'))->label(trans('manage::dashboard.weather.change_state')) !!}

<div class="modal-body">
	{!!
		widget('combo')
			->id('target')
			->options($options)
			->name('state_id')
//			->label(trans('manage::dashboard.weather.choose_city'))
			->valueField('id')
			->searchable()
			->captionField('title')
			->value(user()->preference('state_id') ?? user()->city ?? 81)
	!!}

	{!!
	widget("note")
		->label("tr:manage::dashboard.weather.choose_city_hint")
		->class("mv30")
	!!}

	@include('manage::forms.buttons-for-modal' , [
		"separator" => true,
	])
</div>
