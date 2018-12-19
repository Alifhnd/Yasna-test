@include("manage::layouts.modal-start" , [
	'partial' => true ,
	'form_url' => url('manage/upstream/save/domain'),
	'modal_title' => $model->id? trans('yasna::domains.edit_domain') : trans('yasna::domains.new_domain'),
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

	@include('manage::forms.input' , [
		'name' =>	'slug',
		'class' => 'form-required ltr' ,
		'value' => $model->slug ,
	])

	@include('manage::forms.input' , [
		'name' =>	'alias',
		'class' => 'ltr' ,
		'value' => $model->alias ,
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