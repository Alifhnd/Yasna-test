@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
	'refresh_url' => "manage/upstream/state/cities-row/$model->hashid"
])

{{--
|--------------------------------------------------------------------------
| Title
|--------------------------------------------------------------------------
| & id
--}}

<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->title,
		'size' => "16" ,
		'class' => "font-yekan text-bold" ,
		'link' =>  "modal:manage/upstream/state/cities-edit/-hashid-" ,
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
| Status
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage::widgets.grid-badge" , [
		'condition' => $model->isCapital(),
		'icon' => "certificate",
		'text' => trans('validation.attributes.capital_id'),
		'color' => "success",
		'opacity' => "0.8",
	])
	@include("manage::widgets.grid-badge" , [
		'condition' => $model->trashed() ,
		'icon' => 'times',
		'text' => trans("manage::forms.status_text.deleted"),
		'link' => "modal:manage/upstream/state/activeness/-hashid-" ,
		'color' => 'danger',
	])
</td>

{{--
|--------------------------------------------------------------------------
| Province name
|--------------------------------------------------------------------------
|
--}}

<td>
	@include("manage::widgets.grid-text" , [
		'text' => $model->province()->title,
		'link' => "modal:manage/upstream/state/edit/".$model->province()->hashid,
	])
	@include("manage::widgets.grid-badge" , [
		'condition' => $model->province()->trashed() ,
		'icon' => 'times',
		'text' => trans("manage::forms.status_text.deleted"),
		'color' => 'warning',
	])

</td>

{{--
|--------------------------------------------------------------------------
| Domain
|--------------------------------------------------------------------------
|
--}}

<td>
	@if($model->domain_id)
		@include("manage::widgets.grid-text" , [
			'text' => $model->domain->title,
			'link' => "modal:manage/upstream/domain/edit/".hashid($model->domain_id,'ids'),
		])
		@include("manage::widgets.grid-badge" , [
			'condition' => $model->domain->trashed() ,
			'icon' => 'times',
			'text' => trans("manage::forms.status_text.deleted"),
			'color' => 'warning',
		])
	@else
		-
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
		['pencil' , trans('manage::forms.button.edit') , "modal:manage/upstream/state/cities-edit/-hashid-" ],
		['trash-o' , trans('manage::forms.button.soft_delete') , "modal:manage/upstream/state/activeness/-hashid-" , !$model->trashed()] ,
		['recycle' , trans('manage::forms.button.undelete') , "modal:manage/upstream/state/activeness/-hashid-" , $model->trashed()],
	]
])
