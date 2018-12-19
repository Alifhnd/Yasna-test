{!!
	widget('modal')
		->target(route('users.departments.save'))
    	->labelIf($model->exists, trans_safe('users::department.edit-role', ['title' => $model->title]))
    	->labelIf(!$model->exists, trans_safe('users::department.create'))
!!}


<div class="modal-body">
	{!! widget('hidden')->name('hashid')->value($model->hashid) !!}

	{!!
		widget('input')
			->inForm()
			->required()
			->name('slug')
			->value(DepartmentsTools::departmentSlugOfRole($model))
			->help(trans('validation.hint.unique').' | '.trans('validation.hint.english-only'))
	!!}

	{!!
		widget('input')
			->inForm()
			->required()
			->name('title')
			->value($model->title)
			->help(trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'))
	!!}

	{!!
		widget('input')
			->inForm()
			->required()
			->name('plural_title')
			->value($model->plural_title)
			->help(trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'))
	!!}

	{!!
		widget("icon-picker")
			 ->name('icon')
			 ->value("fa-$model->icon")
			 ->inForm()
			 ->required()
	!!}
</div>

<div class="modal-footer">
	@include("manage::forms.buttons-for-modal")
</div>
