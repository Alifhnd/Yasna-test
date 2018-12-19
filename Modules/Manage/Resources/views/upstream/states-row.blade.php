@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
	'refresh_url' => "manage/upstream/state/row/$model->hashid"
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
		'link' =>  "modal:manage/upstream/state/edit/-hashid-" ,
	])
	@include("manage::widgets.grid-tiny" , [
		'text' => $model->id ,
		'color' => "gray" ,
		'icon' => "bug",
		'class' => "font-tahoma" ,
		'locale' => "en" ,
	]     )
</td>

{{--
|--------------------------------------------------------------------------
| Capital
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->capital()->title,
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
			'link' => "modal:manage/upstream/state/activeness/-hashid-" ,
			'color' => 'danger',
		])

	@else
		@include("manage::widgets.grid-text" , [
			'text' => $model->cities()->count().' '.trans('yasna::states.city'),
			'link' => "url:manage/upstream/states/-hashid-",
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
		['pencil' , trans('manage::forms.button.edit') , "modal:manage/upstream/state/edit/-hashid-" ],
		['flag-checkered' , trans('yasna::states.cities_list') , "url:manage/upstream/states/-hashid-" ],
		['trash-o' , trans('manage::forms.button.soft_delete') , "modal:manage/upstream/state/activeness/-hashid-" , !$model->trashed()] ,
		['recycle' , trans('manage::forms.button.undelete') , "modal:manage/upstream/state/activeness/-hashid-" , $model->trashed()],
	]
])
