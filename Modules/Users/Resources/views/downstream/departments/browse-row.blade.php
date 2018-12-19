@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
	'refresh_url' => DepartmentsTools::browseRowLink($model)
])

@include('users::downstream.departments.browse-row-title')


@include("manage::widgets.grid-actionCol" , [
	"actions" => [
		[
			'pencil',
			trans('manage::forms.button.edit'),
			DepartmentsTools::editLink($model),
			$model->can('edit'),
		],
		[
			'users' ,
			trans('users::department.members-management') ,
			DepartmentsTools::membersLink($model)
		],
		[
			'trash-o' ,
			trans('manage::forms.button.soft_delete') ,
			DepartmentsTools::deleteLink($model),
			!$model->trashed()
		],
		[
			'recycle' ,
			trans('manage::forms.button.undelete') ,
			DepartmentsTools::undeleteLink($model),
			$model->trashed()
		],
	]
])
