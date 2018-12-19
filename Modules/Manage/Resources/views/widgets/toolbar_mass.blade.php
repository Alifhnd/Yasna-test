@include('manage::widgets.grid-action' , [
	'id' => '0',
	'button_size' => isset($mass_size) ?  $mass_size : 'sm' ,
	'button_class' => isset($mass_class)? $mass_class : 'primary' ,
	'button_label' => isset($mass_label)? $mass_label : trans('manage::forms.button.bulk_action'),
	'button_extra' => isset($mass_extra)? $mass_extra :'disabled' ,
	'actions' => $mass_actions ,
])
