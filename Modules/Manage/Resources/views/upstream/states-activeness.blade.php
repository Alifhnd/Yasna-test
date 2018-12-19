@include("manage::layouts.modal-start" , [
	'form_url' => url('manage/upstream/save/state-activeness'),
	'modal_title' => trans('manage::forms.button.change_status'),
	'no_validation' => true ,
])
<div class='modal-body'>

	@include('manage::forms.hidden' , [
		'name' => 'id' ,
		'value' => $model->spreadMeta()->id,
	])

	@include("manage::forms.input" , [
		'name' => "",
		'value' => $model->title ,
		'label' => trans('validation.attributes.title') ,
		'disabled' => true ,
	]     )

	@include('manage::forms.group-start')

	@include('manage::forms.button' , [
		'label' => $model->trashed()? trans('manage::forms.button.undelete') : trans('manage::forms.button.soft_delete') ,
		'shape' => $model->trashed() ? 'success' : 'danger',
		'value' => $model->trashed()? 'restore' : 'delete' ,
		'type' => 'submit' ,
	])

	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.cancel'),
		'shape' => 'link',
		'link' => '$(".modal").modal("hide")',
	])

	@include('manage::forms.group-end')

	@include('manage::forms.feed')

	@include('manage::forms.closer')

</div>
@include("manage::layouts.modal-end")