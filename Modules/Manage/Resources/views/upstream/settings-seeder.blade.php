@include('manage::layouts.modal-start' , [
	'form_url' => '',
	'modal_title' => trans("manage::forms.button.seeder_cheat"),
])
<div class='modal-body'>

	@include('manage::forms.input' , [
		'name' => "title",
		'value' => $model->title ,
		'disabled' => "1" ,
	]      )

	@include('manage::forms.textarea' , [
		'name' => "code",
		'value' => $model->seeder ,
		'disabled' => "1" ,
		'class' => "ltr form-autoSize" ,
		'id' => "txtCode" ,
	]      )

	@include('manage::forms.buttons-for-modal' , [
		'save_label' => trans("manage::forms.button.copy_to_clipboard") ,
		'save_shape' => "primary" ,
		'save_type' => "button" ,
		'save_link' => "forms_clipboard( '#txtCode' )" ,
	]      )


</div>
@include('manage::layouts.modal-end')

