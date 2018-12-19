@php
    $roles = $model->withDisabled()->rolesArray();
@endphp

{{--
|--------------------------------------------------------------------------
| Showing The Roles
|--------------------------------------------------------------------------
|
--}}
@foreach($roles as $request_role)
	@include("users::browse.row-status" , [
		"text" => $model->as($request_role)->title(),
	])
@endforeach


{{--
|--------------------------------------------------------------------------
| When Nothing to Show
|--------------------------------------------------------------------------
|
--}}
@include("manage::widgets.grid-text" , [
	"condition" => !count($roles) ,
	'text' => trans('users::permits.without_role'),
	'color' => "darkgray",
	'size' => "10",
])


{{--
|--------------------------------------------------------------------------
| Showing The Button
|--------------------------------------------------------------------------
|
--}}
@include("manage::widgets.grid-text" , [
	"class" => "btn btn-default btn-sm" ,
	"text" => trans("users::permits.role_management") ,
	'icon' => "cog" ,
	'condition' => $model->canPermit(),
	"div_class" => "mv10" ,
	'link' => "modal:manage/users/act/-hashid-/roles" ,
])
