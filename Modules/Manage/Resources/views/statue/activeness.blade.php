@include('manage::layouts.modal-start' , [
	'form_url' => route("statue-activeness"),
	'modal_title' => trans("manage::statue.activeness"),
])
<div class='modal-body'>

	@include('manage::forms.hiddens' , ['fields' => [
		['hashid' , $module->hashid],
	]])

	@include('manage::forms.input' , [
		'name' => "title",
		'value' => $module->title ,
		'disabled' => 1 ,
	]      )

	@include('manage::forms.buttons-for-modal' , [
		'save_label' => trans($module->active? 'manage::statue.deactivate' : 'manage::statue.activate') ,
		'save_value' => $module->active? 'disable' : 'enable' ,
		'save_shape' => $module->active? 'warning' : 'success' ,
	])

</div>
@include('manage::layouts.modal-end')