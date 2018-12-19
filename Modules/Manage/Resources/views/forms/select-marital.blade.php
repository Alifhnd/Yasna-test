@include('manage::forms.select' , [
	'name' => isset($name)? $name : 'marital' ,
	'value' => isset($value)? $value : '0' ,
//	'blank_value' => isset($blank_value)? $blank_value : 'NO',
	'options' => [
		['id'=>'2' , 'title'=>trans('manage::forms.general.single')],
		['id'=>'1' , 'title'=>trans('manage::forms.general.married')],
	]
])