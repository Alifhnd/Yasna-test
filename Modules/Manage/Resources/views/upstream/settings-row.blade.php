@include('manage::widgets.grid-rowHeader', [
	'handle' => "" ,
	'refresh_url' => "manage/upstream/setting/row/$model->hashid"
])

<td>
	{{ pd($model->order) }}
</td>

{{--
|--------------------------------------------------------------------------
| Title and Features
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->title ,
		'size' => "16" ,
		'class' => "font-yekan text-bold" ,
		'link' => "modal:manage/upstream/setting/set/-hashid-",
	])
	@include("manage::widgets.grid-tiny" , [
		'text' => $model->id.'|'.$model->slug,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
	]     )

</td>


{{--
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
| Together with Data Types and Features
--}}
<td>
	{{ trans('manage::settings.categories.'.$model->category) }}

	@include("manage::widgets.grid-tiny" , [
		'text' => trans('manage::forms.data_type.'.$model->data_type) ,
		'color' => "default" ,
		'icon' => "sliders" ,
		'link' => "modal:manage/upstream/setting/edit/-hashid-" ,
	])

</td>


{{--
|--------------------------------------------------------------------------
| Status
|--------------------------------------------------------------------------
|
--}}
<td>
	@include("manage::widgets.grid-tiny" , [
		'text' => trans('manage::settings.is_localized'),
		'condition' => $model->isLocalized(),
		'icon' => "globe",
		'color' => "green",
	])

	@include("manage::widgets.grid-tiny" , [
		'text' => trans('yasna::seeders.api_discoverable'),
		'condition' => $model->api_discoverable,
		'icon' => "check",
		'color' => "green",
	])

	@include("manage::widgets.grid-badge" , [
		'icon' => 'times',
		'condition' => $model->hasNotDefaultValue() ,
		'text' => trans("manage::settings.without_default_value"),
		'link' => "modal:manage/upstream/setting/set/-hashid-" ,
		'color' => 'danger',
	])


	@include("manage::widgets.grid-badge" , [
		'icon' => 'times',
		'condition' => $model->trashed() ,
		'text' => trans("manage::forms.status_text.deleted"),
		'link' => "modal:manage/upstream/setting/activeness/-hashid-" ,
		'color' => 'danger',
	])

</td>


{{--
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
|
--}}

@include("manage::widgets.grid-actionCol" , [
	"actions" => [
		['pencil' , trans('manage::forms.button.edit') , "modal:manage/upstream/setting/edit/-hashid-" ],
		['sliders' , trans('manage::forms.button.set') , "modal:manage/upstream/setting/set/-hashid-" ],
		['wheelchair-alt' , trans('manage::forms.button.seeder_cheat') , "modal:manage/upstream/setting/seeder/-hashid-"],
		['trash-o' , trans('manage::forms.button.soft_delete') , "modal:manage/upstream/setting/activeness/-hashid-" , !$model->trashed() and !$model->developers_only ] ,
		['recycle' , trans('manage::forms.button.undelete') , "modal:manage/upstream/setting/activeness/-hashid-" , $model->trashed()],
	]
])
