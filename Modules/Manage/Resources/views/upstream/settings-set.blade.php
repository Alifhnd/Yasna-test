@include('manage::layouts.modal-start' , [
	'partial' => true ,
	'form_url' => url('manage/upstream/save/setting-set'),
	'modal_title' => $model->spreadMeta()->title ,
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['id' , $model->id],
	]])

	@include("manage::forms.note" , [
		'text' => $model->hint,
		'condition' => boolval($model->hint),
	]     )

	{{--@include('manage::forms.input' , [--}}
		{{--'name' =>	'title',--}}
		{{--'value' =>	$model->title." ($model->slug) ",--}}
		{{--'extra' => 'disabled'--}}
	{{--])--}}

	@include("manage::widgets.input-$model->data_type" , [
		'condition' => user()->isDeveloper(),
		'value' => $model->withoutPurification()->defaultValue() ,
		'name' => 'default_value' ,
		'label' => trans('validation.attributes.default_value'),
		'class' => 'form-default '.$model->css_class ,
	])

	@if($model->is_localized)
		@foreach(setting('site_locales')->gain() as $lang)
			@include("manage::widgets.input-$model->data_type" , [
				'value' => $model->withoutPurification()->in($lang)->gain() ,
				'name' => $lang,
				'label' => trans("manage::forms.lang.$lang"),
				'class' => $model->css_class ,
			])
		@endforeach
	@else
		@include("manage::widgets.input-$model->data_type" , [
			'value' => $model->withoutPurification()->gain() ,
			'name' => 'custom_value',
			'label' => trans("validation.attributes.custom_value") ,
			'class' => $model->css_class ,
		])
	@endif

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