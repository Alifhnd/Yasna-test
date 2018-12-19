<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->title,
		'class' => "font-yekan" ,
		'size' => "14",
		'link' => DepartmentsTools::editLink($model)
	])

	@include("manage::widgets.grid-text" , [
		'text' => DepartmentsTools::departmentSlugOfRole($model),
		'size' => "10" ,
		'color' => 'gray'
	])


	@include("manage::widgets.grid-text" , [
		'text' => $model->id . '|' . $model->hashid,
		'size' => "10" ,
		'condition' => user()->isDeveloper(),
		'color' => 'gray'
	])

	@include('manage::widgets.grid-date', [
		'date' => $model->created_at
	])
</td>
