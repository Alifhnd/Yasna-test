@include('manage::layouts.modal-start' , [
	'partial' => true ,
	'form_url' => url('manage/downstream/save/setting'),
	'modal_title' => $model->title ,
])

<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['id' , $model->id],
	]])

	@include("manage::forms.note" , [
		'text' => $model->hint,
		'condition' => boolval($model->hint),
	]     )

	@if($model->is_localized)
			@foreach(setting('site_locales')->gain() as $lang)
			@include("manage::widgets.input-$model->data_type" , [
				'value' => $model->nocache()->withoutPurification()->in($lang)->gain() ,
				'name' => $model->slug . "--in--" . $lang,
				'label' => trans("manage::forms.lang.$lang"),
				'class' => ($lang!='fa' and $lang!='ar')? "$model->css_class ltr " : $model->css_class ,
			])
		@endforeach
	@else
		@include("manage::widgets.input-$model->data_type" , [
			'value' => $model->nocache()->withoutPurification()->gain() ,
			'name' => $model->slug ,
			'label' => ' ' , // trans("validation.attributes.custom_value") ,
			'class' => $model->css_class ,
		])
	@endif


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
