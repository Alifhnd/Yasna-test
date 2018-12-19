@include('manage::layouts.modal-start' , [
	'partial' => true ,
	'form_url' => url('manage/downstream/save/setting'),
	'modal_title' => trans('manage::settings.categories.'.$model->category) ,
])

<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['id' , $model->id],
	]])

	@foreach($settings as $setting)
		@include("manage::forms.sep" , [
			'label' => $setting->title,
			'class' => "font-yekan text-bold f16" ,
		]     )

		@include("manage::forms.note" , [
			'text' => $setting->hint,
			'condition' => boolval($setting->hint),
		]     )


	@if($setting->is_localized)
			@foreach(setting('site_locales')->gain() as $lang)
				@include("manage::widgets.input-$setting->data_type" , [
					'value' => $setting->nocache()->withoutPurification()->in($lang)->gain() ,
					'name' => $setting->slug . "--in--" . $lang,
					'label' => trans("manage::forms.lang.$lang"),
					'class' => ($lang!='fa' and $lang!='ar')? "$setting->css_class ltr " : $setting->css_class ,
				])
			@endforeach
		@else
			@include("manage::widgets.input-$setting->data_type" , [
				'value' => $setting->nocache()->withoutPurification()->gain() ,
				'name' => $setting->slug ,
				'label' => ' ' , // trans("validation.attributes.custom_value") ,
				'class' => $setting->css_class ,
			])
		@endif


	@endforeach

</div>

<div class="modal-footer" style="text-align: right !important;">
	@include('manage::forms.button' , [
		'id' => 'btnSave' ,
		'label' => trans('manage::forms.button.save'),
		'shape' => 'success',
		'type' => 'submit' ,
		'value' => 'save' ,
	])

	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.cancel'),
		'shape' => 'link',
		'link' => '$(".modal").modal("hide")'
	])

	<div class="mv10">
		@include('manage::forms.feed')
	</div>

</div>

@include('manage::forms.closer')
@include('manage::layouts.modal-end')