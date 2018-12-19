@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
])


{{--
|--------------------------------------------------------------------------
| Title
|--------------------------------------------------------------------------
|
--}}
<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->title,
		'size' => "16" ,
		'class' => "font-yekan text-bold" ,
	])
	@include("manage::widgets.grid-tiny" , [
		'condition' => user()->isDeveloper() ,
		'text' => $model->slug.'|'.$model->order ,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
	]     )

</td>


{{--
|--------------------------------------------------------------------------
| Version
|--------------------------------------------------------------------------
|
--}}
<td>

	@include("manage::widgets.grid-text" , [
		'text' => $model->version,
	])
	@include("manage::widgets.grid-date" , [
		'date' => $model->release_date ,
		'default' => "fixed" ,
		'format' => 'j F Y' ,
		"condition" => $model->release_date != '@TODO',
	]     )
</td>

{{--
|--------------------------------------------------------------------------
| Statue
|--------------------------------------------------------------------------
|
--}}
<td>
	@include("manage::widgets.grid-badge" , [
		'condition' => user()->isDeveloper() ,
		'icon' => config("manage.status.icon.$model->status"),
		'text' => trans("manage::forms.status_text.$model->status"),
		'link' => in_array($model->slug , ['Yasna' , 'Manage']) ? null : "modal:manage/statue/activeness/-hashid-" ,
		'color' => config("manage.status.color.$model->status"),
	])


	@include("manage::widgets.grid-badge" , [
		'condition' => !user()->isDeveloper() ,
		'icon' => 'check',
		'text' => trans_safe("manage::statue.up_to_date"),
		'color' => 'success',
	])

	{{-- @TODO: UPDATE STATUS --}}
</td>
