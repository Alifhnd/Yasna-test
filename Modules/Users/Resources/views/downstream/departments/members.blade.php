@php $username_field = user()->usernameField() @endphp

{!!
	widget('modal')
    	->label($model->plural_title)
!!}


<div class="modal-body">

	@include('users::downstream.departments.members-new-form')
	@include('users::downstream.departments.members-list')

</div>


<div class="modal-footer">
	{!!
		widget('button')
			->label(trans('manage::forms.button.cancel'))
			->id('btnCancel')
			->shape('link')
			->onClick('$(".modal").modal("hide")')
	!!}
</div>
