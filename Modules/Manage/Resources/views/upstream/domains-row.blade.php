@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
	'refresh_url' => "manage/upstream/domain/row/$model->hashid"
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
		'link' =>  "modal:manage/upstream/domain/edit/-hashid-" ,
	])
	@include("manage::widgets.grid-tiny" , [
		'text' => $model->slug.'|'.$model->id ,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
	]     )
</td>

{{--
|--------------------------------------------------------------------------
| Alias
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->alias,
		'locale' => "en" ,
	])
</td>


{{--
|--------------------------------------------------------------------------
| Cities
|--------------------------------------------------------------------------
|
--}}

<td>
	@if($model->trashed())
		@include("manage::widgets.grid-badge" , [
			'icon' => 'times',
			'text' => trans("manage::forms.status_text.deleted"),
			'link' => "modal:manage/upstream/domain/activeness/-hashid-" ,
			'color' => 'danger',
		])

	@else
		@include("manage::widgets.grid-text" , [
			'text' => $model->states()->count().' '.trans('yasna::states.city'),
			'link' => "url:manage/upstream/domains/-hashid-",
		])
	@endif
</td>


{{--
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
|
--}}

@include("manage::widgets.grid-actionCol" , [
	"actions" => [
		['pencil' , trans('manage::forms.button.edit') , "modal:manage/upstream/domain/edit/-hashid-" ],
		['flag-checkered' , trans('yasna::states.cities_list') , "url:manage/upstream/domains/-hashid-" ],
		['trash-o' , trans('manage::forms.button.soft_delete') , "modal:manage/upstream/domain/activeness/-hashid-" , !$model->trashed() and $model->id!='1'] ,
		['recycle' , trans('manage::forms.button.undelete') , "modal:manage/upstream/domain/activeness/-hashid-" , $model->trashed()],
	]
])
