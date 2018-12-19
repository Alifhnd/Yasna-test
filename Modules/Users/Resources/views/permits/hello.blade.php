<div class="mv10 f20" style="margin-bottom: 20px">
	{{ $model->full_name }}
</div>

@include("manage::forms.input" , [
	'name' => "",
	'label' => trans("users::permits.user_role") ,
	'value' => $request_role->title  ,
	'disabled' => "1" ,
]     )


{{--
|--------------------------------------------------------------------------
| Status Menu
|--------------------------------------------------------------------------
|
--}}
@php

	if($model->withDisabled()->is_not_a($request_role->slug)) {
		$current_status         = '';
		$include_delete_options = false;
	}
	elseif($model->as($request_role->slug)->disabled()) {
		$current_status         = 'ban';
		$include_delete_options = true;
	}

	else {
		$current_status         = $model->as($request_role->slug)->status();
		$include_delete_options = true;
	}

	if(!$model->as($request_role->slug)->canDelete()) {
		$include_delete_options = false;
	}

@endphp

@include("manage::forms.select" , [
	'name' => "status" ,
	'id' => "cmbStatus",
	'options' => $request_role->statusCombo($include_delete_options) ,
	'value_field' => "0" ,
	'caption_field' => "1" ,
	'value' => $current_status ,
	'blank_value' => $include_delete_options? 'NO' : '' ,
	'on_change' => "roleAttachmentEffect( '$request_role->id')" ,
	'initially_run_onchange' => false,
]     )




{{--
|--------------------------------------------------------------------------
| Support Teams
|--------------------------------------------------------------------------
|
--}}
@php
    $support_roles = $request_role::supportRoles();
@endphp
@if($support_roles->count())
	@include("manage::forms.sep")

	@include("manage::forms.group-start" , [
		'label' => trans("users::permits.support_roles") ,
	])

	@foreach($support_roles as $support_role)

		@include("manage::forms.check" , [
			'name' => $support_role->slug,
			'value' => $model->is_a($support_role->slug) ,
			'label' => $support_role->title ,
		]     )

	@endforeach

	@include("manage::forms.group-end")
@endif
