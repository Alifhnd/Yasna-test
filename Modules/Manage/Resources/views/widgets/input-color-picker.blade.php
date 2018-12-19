{!!
widget("color-picker")
	->name(isset($name)? $name : false)
	->label(isset($label)? $label : trans("validation.attributes.$name"))
	->hint(isset($hint)? $hint : false)
	->value(isset($value)? $value : null)
	->inForm()
!!}