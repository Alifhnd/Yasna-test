<div class="row">
	<div class="col-xs-12 text-right">
		{!!
			widget('button')
				->shape('success')
				->icon('plus-circle')
				->label(trans_safe('users::department.add-member'))
				->type('button')
				->class('add-member-panel-opener')
		!!}
	</div>
</div>


<div class="panel panel-default add-member-panel" style="display: none; margin-top: 10px">

	<div class="panel-heading">
		{{ trans_safe('users::department.add-member') }}
	</div>

	{!!
		widget('form-open')
			->target(route('users.departments.search-member'))
			->class('js')
	!!}

	{!! widget('hidden')->name('id')->value($model->hashid) !!}

	<div class="row">
		<div class="col-xs-9">
			{!!
				widget('input')
					->inForm()
					->name($username_field)
					->required()
			!!}
		</div>

		<div class="col-xs-3">
			<div class="form-group">
				{!!
					widget('button')
						->inForm()
						->class('btn-sm')
						->label(trans_safe('manage::forms.button.search'))
						->type('submit')
						->shape('info')
				!!}
			</div>
		</div>
	</div>

	{!! widget('feed') !!}

	{!! widget('form-close') !!}
</div>
