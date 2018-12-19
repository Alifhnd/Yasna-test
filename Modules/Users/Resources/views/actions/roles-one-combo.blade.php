<div class="refresh">{{ url("manage/users/act/$model->hashid/refreshRoleRow/$role->hashid") }}</div>

<div class="row pv5 -summery">

	{{--
	|--------------------------------------------------------------------------
	| Role Summery
	|--------------------------------------------------------------------------
	| Check if the role is attached, and if so, is it active or not.
	| Also writes the currenct status if defined.
	--}}

	<div class="col-md-9">
		@if($model->withDisabled()->is_not_a($role->slug))
			@include("manage::widgets.grid-text" , [
				'color' => "gray",
				'icon' => "times" ,
				'text' => trans("users::permits.now_without") ,
				'link' => "$('#divRole-$role->id .-summery , #divRole-$role->id .-edit').slideToggle('fast')" ,
			]     )
		@elseif($model->as($role->slug)->enabled())
			@include("manage::widgets.grid-text" , [
				'color' => "success",
				'icon' => "check" ,
				'fake' => $role->has_status_rules? $status = " (".$role->statusRule( $model->as($role->slug)->status()  , true).") " : $status = "" ,
				'text' => trans('users::permits.now_active').$status ,
				'link' => "$('#divRole-$role->id .-summery , #divRole-$role->id .-edit').slideToggle('fast')" ,
		]     )
		@else
			@include("manage::widgets.grid-text" , [
				'color' => "danger",
				'icon' => "ban",
				'text' => trans('users::permits.now_blocked') ,
				'link' => "$('#divRole-$role->id .-summery , #divRole-$role->id .-edit').slideToggle('fast')" ,
			]     )
		@endif
	</div>

	{{--
	|--------------------------------------------------------------------------
	| Change Button (Edit Handle)
	|--------------------------------------------------------------------------
	|
	--}}
	<div class="col-md-3">
		@include("manage::widgets.grid-text" , [
			'id' => "cmdRoleEdit-$role->id" ,
			'text' => trans('manage::forms.button.edit'),
			'link' => "$('#divRole-$role->id .-summery , #divRole-$role->id .-edit').slideToggle('fast')" ,
			'class' => "btn btn-default btn-xs noDisplay " ,
			'icon' => "pencil" ,
		]     )

	</div>

</div>


<div class="row -edit noDisplay">
	{{--
	|--------------------------------------------------------------------------
	| Combo
	|--------------------------------------------------------------------------
	|
	--}}
	@php
		if($model->withDisabled()->is_not_a($role->slug)) {
			$current_status         = '';
			$include_delete_options = false;
		}
		elseif($model->as($role->slug)->disabled()) {
			$current_status         = 'ban';
			$include_delete_options = true;
		}

		else {
			$current_status         = $model->as($role->slug)->status();
			$include_delete_options = true;
		}

	@endphp

	<div class="col-md-6">

		@include("manage::forms.select_self" , [
			'name' => "status" ,
			'id' => "cmbStatus-$role->id",
			'options' => $role->statusCombo($include_delete_options) ,
			'value_field' => "0" ,
			'caption_field' => "1" ,
			'value' => $current_status ,
			'blank_value' => $include_delete_options? 'NO' : '' ,
			'on_change' => "roleAttachmentEffect( '$role->id')" ,
			'initially_run_onchange' => false,
		]     )
	</div>


	{{--
	|--------------------------------------------------------------------------
	| Save Button
	|--------------------------------------------------------------------------
	|
	--}}
	<div class="col-md-3">
		<button id="btnRoleSave-{{$role->id}}" type="button" class="btn noDisplay btn-taha" onclick="roleAttachmentSave('{{$model->id}}' , '{{$role->id}}' , '{{$role->slug}}' , '{{$model->hashid}}')">
			{{ trans('manage::forms.button.save') }}
		</button>
	</div>


	{{--
	|--------------------------------------------------------------------------
	| Cancel Button
	|--------------------------------------------------------------------------
	|
	--}}
	<div class="col-md-3">

		<button type="button" class="btn btn-default btn-taha" onclick="{{"$('#divRole-$role->id .-summery , #divRole-$role->id .-edit').slideToggle('fast')"}}">
			{{ trans('manage::forms.button.cancel') }}
		</button>
	</div>
</div>
