@include('manage::widgets.grid-rowHeader', [
	'handle' => "counter" ,
	'refresh_url' => "manage/upstream/roles/row/$model->hashid"
])

<td>
    @include("users::upstream.roles.browse.row-title")
</td>

{{--<td>--}}
{{--    @include("users::upstream.roles.browse.row-status")--}}
{{--</td>--}}

@include("users::upstream.roles.browse.row-buttons")

<td id="tdCount-{{$model->hashid}}" data-src="manage/upstream/roles/users/{{$model->hashid}}">
    @include("users::upstream.roles.browse.row-people")
</td>

@include("manage::widgets.grid-actionCol" , [
	"actions" => [
		['pencil' , trans('manage::forms.button.edit') , "modal:manage/upstream/roles/edit/-hashid-" ],
		['taxi' , trans('manage::settings.title_in_other_locales') , "modal:manage/upstream/roles/titles/-hashid-" ],
		['trash-o' , trans('manage::forms.button.soft_delete') , "modal:manage/upstream/roles/activeness/-hashid-" , !$model->trashed()] ,
		['recycle' , trans('manage::forms.button.undelete') , "modal:manage/upstream/roles/activeness/-hashid-" , $model->trashed()],
	]
])
