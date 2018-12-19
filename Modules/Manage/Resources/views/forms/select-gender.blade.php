@include('manage::forms.select' , [
	'name' => isset($name)? $name : 'gender' ,
	'value' => isset($value)? $value : '0' ,
	'class' => isset($class)? $class : '' ,
	'blank_value' => isset($blank_value)? $blank_value : 'NO',

	'options' => [
		['id'=>'2' , 'title'=>trans('manage::forms.general.female')],
		['id'=>'1' , 'title'=>trans('manage::forms.general.male')],
		['id'=>'3' , 'title'=>trans('manage::forms.general.other_gender')],
	]
])