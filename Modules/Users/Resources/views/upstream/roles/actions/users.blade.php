@include("manage::widgets.grid-text" , [
	'condition' => $count = $model->users()->count() ,
	'text' => number_format($count) .' '.trans('users::forms.person'),
	'link' => $model->trashed() ? '' : "url:$model->users_browse_link" ,
]     )

@include("manage::widgets.grid-text" , [
	'condition' => !$count,
	'text' => trans('manage::forms.general.nobody') ,
	'link' => $model->trashed() ? '' : "url:$model->users_browse_link" ,
]     )


@include("manage::widgets.grid-text" , [
	'text' => trans("manage::forms.button.count_again"),
	'link' => "divReload('tdCount-$model->hashid')" ,
	'size' => "10" ,
	'color' => "darkgray" ,
]     )

