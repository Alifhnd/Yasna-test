@include("manage::layouts.modal-start" , [
	'form_url' => $form_url , // <~~ MUST be Passed. No Automatic/Safe Replacement here.
	'modal_title' => isset($modal_title)? $modal_title : trans('manage::forms.button.hard_delete'),
	'no_validation' => true ,
])
<div class='modal-body'>

	@include('manage::forms.hidden' , [
		'name' => 'hashid' ,
		'value' => $model->hashid,
	])

	@include("manage::forms.input" , [
		'name' => "",
		'value' => isset($title_value)? $title_value : $model->title ,
		'label' => isset($title_label)? $title_label : trans('validation.attributes.title') ,
		'disabled' => true ,
	]     )

	@include("manage::forms.note" , [
		'text' => isset($note_text)? $note_text : trans('manage::forms.feed.hard_delete_notice'),
		'shape' => isset($note_shape)? $note_shape : "danger",
	])


	@include('manage::forms.buttons-for-modal' , [
		'save_label' => isset($save_label)? $save_label : trans('manage::forms.button.sure_hard_delete')  ,
		'save_shape' => isset($save_shape)? $save_shape : 'danger' ,
	])
</div>