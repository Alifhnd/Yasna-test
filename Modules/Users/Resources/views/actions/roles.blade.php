@include('manage::layouts.modal-start' , [
	'form_url' => "#",
	'modal_title' => trans("users::permits.user_role"),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $model->hashid],
	]])

	@include('manage::forms.input' , [
		'name' => "",
		'value' => $model->full_name ,
		'label' => trans("validation.attributes.name_first") ,
		'disabled' => true ,
	]      )


	@foreach($model->rolesTable() as $role)
		@include("users::actions.roles-one")
	@endforeach


</div>
@include('manage::layouts.modal-end')