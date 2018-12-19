{!!
widget("modal")
	->target('name:login_as')
	->label('tr:users::forms.login_as')
!!}

{!!
widget("hidden")
	->name('id')
	->value($model->hashid)
!!}

<div class="modal-body">

	{!!
	widget("input")
		->name('name_first')
		->value($model->full_name)
		->inForm()
	!!}

	@include("manage::forms.buttons-for-modal")
</div>
