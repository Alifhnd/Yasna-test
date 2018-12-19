@include("manage::layouts.modal-start" , [
	'form_url' => url('manage/upstream/save/state'),
	'modal_title' => $model->id? trans('yasna::states.province_edit') : trans('yasna::states.province_new'),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['id' , $model->id],
		['parent_id' , '0']
	]])


	@include('manage::forms.input' , [
		'name' =>	'title',
		'class' => 'form-required form-default' ,
		'value' => $model->title ,
		'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'),
	])

	@include('manage::forms.select' , [
		'name' =>	'capital_id',
	//	'class' => 'form-required',
		'options' => $model->cities()->orderBy('title')->get()->toArray() ,
		'value' => $model->id? $model->capital()->id : '0' ,
		'blank_value' => '0' ,
		'search' => true ,
	])

	@include('manage::forms.group-start')

	@include('manage::forms.button' , [
		'id' => 'btnSave' ,
		'label' => trans('manage::forms.button.save'),
		'shape' => 'success',
		'type' => 'submit' ,
		'value' => 'save' ,
		'class' => '-delHandle'
	])

	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.cancel'),
		'shape' => 'link',
		'link' => '$(".modal").modal("hide")',
	])

	@include('manage::forms.group-end')

	@include('manage::forms.feed')

</div>
@include("manage::layouts.modal-end")