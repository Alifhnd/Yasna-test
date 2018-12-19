@include("manage::layouts.modal-start" , [
	'partial' => true ,
	'form_url' => url('manage/upstream/save/state-city'),
	'modal_title' => $model->id? trans('yasna::states.city_edit') : trans('yasna::states.city_new'),
])
<div class='modal-body'>

	@include('manage::forms.hidden' , [
		'name' => 'id' ,
		'value' => $model->id ,
	])

	@include('manage::forms.input' , [
		'name' =>	'title',
		'class' => 'form-required form-default' ,
		'value' => $model->title ,
	])

	@include('manage::forms.select' , [
		'name' =>	'province_id',
		'class' => 'form-required',
		'options' => $model::getProvinces()->orderBy('title')->get()->toArray(),
		'value' => $model->parent_id  ,
		'blank_value' => '0' ,
	])

	@include('manage::forms.select' , [
		'condition' => model('yasna::domain')::count() ,
		'name' =>	'domain_id',
		'options' => model('yasna::domain')::orderBy('title')->get(),
		'value' => $model->id? $model->domain_id : $model->guess_domain ,
		'blank_value' => '0' ,
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