<?php
if(!isset($name))
	$name = 'date' ;

if(!isset($id))
	$id = 'txtDate'.rand(1,1000) ;

//if(isset($value) and is_object($value))
//	$value = $value->$name ;

if(isset($class))
	$class = 'datepicker '.$class ;
else
	$class = 'datepicker ';

if(isset($value) and $value and $value!= '0000-00-00 00:00:00') {
	$j_value = jdate($value)->format('Y/m/d');
	$carbon = new \Carbon\Carbon($value);
	$value = $carbon->toDateString() ;

}
else {
	$j_value = '' ;
	$value = '' ;
}

if(isset($in_form) and !$in_form) {
	$view = 'manage::forms.input-self' ;
}
else {
	$view = 'manage::forms.input' ;
}
?>

@if(!isset($condition) or $condition)

	@include($view , [
		'name' => $name,
		'label' => isset($label)? $label : trans("validation.attributes.$name"),
		'value' => $j_value,
		'id' => $id,
		'type' => isset($type)? $type : '',
		'class' => $class,
		'placeholder' =>  isset($placeholder)? $placeholder : '',
		'hint' => isset($hint)? $hint : '',
		'extra' => isset($extra)? $extra : '',
	])
	@include('manage::forms.hidden' , [
		'name' => $name ,
		'id' => $id."_extra" ,
		'value' => $value ,
		'class' => '' ,
	])
@endif