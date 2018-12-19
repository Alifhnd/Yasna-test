@include('manage::layouts.modal-start' , [
	'form_url' => route('user-save-password'),
	'modal_title' => trans('users::forms.change_password'),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $model->hashid],
	]])


	@include('manage::forms.input' , [
		'name' => '',
		'label' => trans('validation.attributes.name_first'),
		'value' => $model->full_name ,
		'extra' => 'disabled' ,
	])

	@include('manage::forms.input' , [
		'name' => '',
		'label' => trans('validation.attributes.mobile'),
		'value' => $model->mobile ,
		'extra' => 'disabled' ,
	])

	@include('manage::forms.input' , [
		'name' => 'password',
		'value' => rand(10000000 , 99999999),
		'class' => 'form-required ltr form-default' ,
		'hint' => trans('users::forms.password_hint')
	])

	{{--@include("manage::forms.toggle-form" , [--}}
		{{--'name' => "sms_notify",--}}
		{{--'label' => trans("users::forms.notify-with-sms") ,--}}
		{{--'value' => "1" ,--}}
	{{--]     )--}}


	@include('manage::forms.buttons-for-modal')

</div>
@include('manage::layouts.modal-end')