{!!widget("separator") !!}

{!!
widget("input")
	->name("min_active_status")
	->label("tr:users::permits.min_active_status")
	->value(8) //->value(intval($model->min_active_status))
	->inForm()
	->disabled()
!!}

{!!
widget("textarea")
	->name('modules')
	->label("tr:users::permits.modules")
	->value($model->modulesArrayForTextInput())
	->autoSize()
	->ltr()
	->inForm()
	->rows(3)
!!}

{!!
widget("textarea")
	->name('status_rule')
	->value($model->statusRuleForTextInput())
	->autosize()
	->ltr()
	->inForm()
	->rows(3)
!!}

