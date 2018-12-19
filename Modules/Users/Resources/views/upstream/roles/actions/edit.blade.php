@include("manage::layouts.modal-start" , [
	'form_url' => url('manage/upstream/save/role'),
	'modal_title' => $model->id? trans('manage::forms.button.edit') : trans('manage::forms.button.add'),
])

<div class="modal-body">
    @include('manage::forms.hidden' , [
         'name' => 'id' ,
         'value' => $model->id,
    ])

    @include('manage::forms.input' , [
         'name' =>	'slug',
         'class' =>	'form-required ltr form-default',
         'value' =>	$model ,
         'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.english-only'),
    ])


    @include('manage::forms.input' , [
         'name' =>	'title',
         'value' =>	$model,
         'class' => 'form-required' ,
         'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'),
    ])

    @include('manage::forms.input' , [
         'name' =>	'plural_title',
         'value' =>	$model,
         'class' => 'form-required' ,
         'hint' =>	trans('validation.hint.unique').' | '.trans('validation.hint.persian-only'),
    ])

    {!!
    widget("icon-picker")
         ->name('icon')
         ->value("fa-$model->icon")
         ->inForm()
         ->required()
    !!}

    {!!
    widget("toggle")
         ->name("is_admin")
         ->inForm()
         ->label("tr:users::permits.is_admin")
         ->value($model->is_admin)
    !!}

    {!!
    widget("toggle")
    	->name("is_privileged")
    	->inForm()
    	->label("tr:users::permits.privileged")
    	->value($model->isPrivileged())
    	->onChange("$('.-privileges').slideToggle('fast')")
    !!}


    <div class="-privileges {{ $model->isPrivileged() ?: "noDisplay" }}" >
        @include("users::upstream.roles.actions.edit-privileges")
    </div>


</div>
<div class="modal-footer">
    @include("manage::forms.buttons-for-modal")
</div>

@include("manage::layouts.modal-end")
