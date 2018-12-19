{!!
widget("modal")
	->target('manage/upstream/save/role-titles')
	->label("tr:manage::settings.title_in_other_locales")
	->noValidation()
!!}

<div class='modal-body'>

	{!!
	widget("hidden")
		->name('hashid')
		->value($model->hashid)
	!!}

	@include("manage::forms.input" , [
		'name' => "",
		'value' => $model->slug ,
		'label' => trans('validation.attributes.slug') ,
		'disabled' => true ,
	]     )

	@foreach(getSetting('site_locales') as $locale)
		@include("users::upstream.roles.actions.titles-locales")
	@endforeach

</div>
<div class="modal-footer">
	@include("manage::forms.buttons-for-modal")
</div>
