@include("manage::widgets.grid-text" , [
	'text' => $model->full_name,
	'class' => "font-yekan" ,
	'size' => "14" ,
	'link' => userProfile($model)->link(),
])

@include("manage::widgets.grid-tiny" , [
	'fake' => $auth_field =  config('auth.providers.users.field_name'),
	'text' => $model->$auth_field ,
	'icon' => "user-circle" ,
	'size' => "10" ,
	'locale' => "en" ,
	'color' => "gray" ,
]     )

@include("manage::widgets.grid-tiny" , [
	'text' => "$model->id|$model->hashid" ,
	'color' => "gray" ,
	'icon' => "bug",
	'class' => "font-tahoma" ,
	'locale' => "en" ,
]     )
