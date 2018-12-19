@include('manage::layouts.modal-start' , [
	'form_url' => route("user-save-permits"),
	'modal_title' => trans("users::permits.permit"),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $model->hashid],
		['role_slug' , $request_role->slug]
	]])


	@include("users::permits.index")
</div>

<div>
	@include('manage::forms.buttons-for-modal')
</div>

@include('manage::layouts.modal-end')
