@include("manage::layouts.modal-start" , [
	'form_url' => $form_url , // <~~ MUST be Passed. No Automatic/Safe Replacement here.
	'modal_title' => isset($modal_title)? $modal_title : trans('manage::forms.feed.mass_action'),
	'no_validation' => true ,
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['ids' , null ],
	]])

	@include("manage::forms.input" , [
		'name' => '',
		'id' => 'txtCount' ,
		'label' => trans('validation.attributes.items'),
		'extra' => 'disabled' ,
	])

	@include("manage::forms.note" , [
		'condition' => isset($note_text) ,
		'text' => isset($note_text)? $note_text : 'never applies!',
		'shape' => isset($note_shape)? $note_shape : "info",
	])


	@include('manage::forms.buttons-for-modal' , [
		'save_label' => isset($save_label)? $save_label : trans('manage::forms.button.send_and_save')  ,
		'save_shape' => isset($save_shape)? $save_shape : 'primary' ,
	])
</div>
<script>gridSelector('get')</script>