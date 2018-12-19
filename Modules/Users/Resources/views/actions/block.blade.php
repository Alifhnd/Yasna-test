@include('manage::layouts.modal-start' , [
	'form_url' => route("user-save-block"),
	'modal_title' => trans( "users::forms." . $action = $option[1] ),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $model->hashid],
		['role_slug' , $role_slug = $option[0] ]
	]])

	@include("manage::forms.input" , [
		'name' => "",
		'value' => $model->full_name ,
		'label' => trans("validation.attributes.name_first") ,
		'disabled' => true ,
	] )

	@include('manage::forms.input' , [
		'name' => "",
		'value' => $model->as($role_slug)->title() ,
		'label' => trans("validation.attributes.role_slug") ,
		'disabled' => true ,
	])

	@include('manage::forms.buttons-for-modal' , [
		'save_label' => trans( "users::forms.$action") ,
		'save_shape' => $action == 'block' ? "danger" : 'primary',
		'save_value' => $action ,
	])

</div>
@include('manage::layouts.modal-end')