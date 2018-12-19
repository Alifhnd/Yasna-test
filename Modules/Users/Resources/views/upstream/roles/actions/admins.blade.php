@include("manage::layouts.modal-start" , [
	'form_url' => url('manage/upstream/save/role-admins'),
	'modal_title' => trans("users::permits.all_admin_roles"),
])
<div class='modal-body'>

	@include('manage::forms.input' , [
		'name' => '',
		'id' => 'txtCount' ,
		'label' => trans('validation.attributes.items'),
		'value' => pd(count(model('yasna::role')::adminRoles())).' '.trans("manage::forms.general.numbers"). ' '.trans("users::permits.user_role"),
		'extra' => 'disabled' ,
	])

	<div class="-privileges" >
		@include("users::upstream.roles.actions.edit-privileges")
	</div>

	<div id="divSample" class="noDisplay">
		{!! widget("separator")	!!}
		@include("manage::widgets.input-textarea" , [
		'label' => trans('users::permits.module_sample'),
			'name' => "_sample",
			'value' => $model->sample_modules,
			'class' =>	'ltr',
			'rows' => "3",
		])
		@include("manage::widgets.input-textarea" , [
		'label' => trans('users::permits.rule_sample'),
			'name' => "_sample",
			'value' => $model->sample_rules ,
			'class' =>	'ltr',
			'rows' => "3",
		]     )


		{!!
		widget("note")
			->label('tr:users::permits.example_hint')
		!!}
		{!! widget("separator")	!!}

	</div>


	@include('manage::forms.group-start')

	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.save'),
		'shape' => 'primary',
		'type' => 'submit' ,
	])
	@include('manage::forms.button' , [
		'label' => trans('manage::forms.button.cancel'),
		'shape' => 'link',
		'link' => '$(".modal").modal("hide")',
	])

	@include('manage::forms.button' , [
		'label' => trans_safe("users::permits.example"),
		'shape' => 'link',
		'class' => "text-gray" ,
		'link' => '$("#divSample").show()',
	])

	@include('manage::forms.group-end')

	@include('manage::forms.feed')

</div>
@include("manage::layouts.modal-end")
