@include('manage::layouts.modal-start' , [
	'form_url' => route("user-save"),
	'modal_title' => trans( $model->id? "manage::forms.button.edit_info" : "users::forms.create_new_person" ),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $model->hashid],
		['_role_slug' , isset($role_slug)? $role_slug : 'all']
	]])


	@foreach(user()->renderFormItems() as $item)
		{!!
		widget($item['type'])
			->name($name = $item['field_name'])
			->inForm()
			->class($item['class'])
			->style($item['style'])
			->label($item['label'])
			->hint($item['hint'])
			->extra($item['extra'])
			->requiredIf($item['is_required'])
			->value($model->$name)
		!!}

	@endforeach


	@include('manage::forms.note' , [
		'text' => trans("users::forms.default_password"),
		'condition' => !$model->id ,
	]      )

	@include('manage::forms.buttons-for-modal')

</div>
@include('manage::layouts.modal-end')