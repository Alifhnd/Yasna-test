<td width="100">
	@include('manage::widgets.grid-action' , [
		'id' => $model->id ,
		'fake' => !isset($refresh_action) ? $refresh_action = true : '' ,
		'fake2' => $refresh_action ? array_unshift($actions ,
			['retweet' , trans('manage::forms.button.refresh') , "rowUpdate('auto','$model->hashid')" ]
		) : false ,
	])
</td>