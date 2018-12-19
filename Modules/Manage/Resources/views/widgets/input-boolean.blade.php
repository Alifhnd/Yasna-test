{{--@include("manage::forms.tBoolean")--}}
@include("manage::forms.toggle-form" , [
	'data_on' => trans("manage::forms.logic.yes") ,
	'data_off' => trans("manage::forms.logic.no") ,
	'data_width' => "80" ,
]     )
