@include('manage::layouts.modal-start' , [
	'form_url' => url('manage/upstream/save/setting'),
	'modal_title' => $model->id? trans('manage::forms.button.edit') : trans('manage::forms.button.add'),
])
<div class='modal-body'>

	@include('manage::forms.hidden' , [
		'name' => 'id' ,
		'value' => $model->id,
	])

	@include('manage::forms.input' , [
		'name' =>	'title',
		'value' =>	$model->title,
		'class' => 'form-required form-default' ,
		'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'),
	])

	@include('manage::forms.input' , [
		'name' =>	'slug',
		'class' =>	'form-required ltr',
		'value' =>	$model->slug ,
		'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.english-only'),
	])

	@include("manage::forms.input" , [
		'name' => "order",
		'class' => "form-required" ,
		'value' => $model->order ,
	]     )

	@include('manage::forms.select' , [
		'name' => 'category' ,
		'class' => 'form-required',
		'options' => $model->categoriesCombo() ,
		'caption_field' => '1' ,
		'value_field' => '0' ,
		'value' => $model->category ,
	])

	@include('manage::forms.select' , [
		'name' => 'data_type' ,
		'class' => 'form-required',
		'options' => $model->dataTypesCombo() ,
		'caption_field' => '1' ,
		'value_field' => '0' ,
		'value' => $model->data_type ,
	])

	@include("manage::forms.textarea" , [
		'name' => "hint",
		'value' => $model->hint ,
	]     )

	@include("manage::forms.input" , [
		'name' => "css_class",
		'value' => $model->css_class ,
		'class' => "ltr" ,
	]     )


	@include('manage::forms.toggle-form' , [
		'name' => 'is_localized',
		'value' => $model->isLocalized(),
	])

	{!!
	widget("toggle")
		->name("api_discoverable")
		->label("tr:yasna::seeders.api_discoverable")
		->value($model->api_discoverable)
		->inForm()
	!!}

</div>
<div class="modal-footer">
	@include('manage::forms.group-start')

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


	@include('manage::forms.group-end')

	@include('manage::forms.feed')

	@include('manage::forms.closer')

</div>
@include('manage::layouts.modal-end')
