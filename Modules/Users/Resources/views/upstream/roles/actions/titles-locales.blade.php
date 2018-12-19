{!!
widget("separator")
	->label("tr:manage::forms.lang.$locale")
	->containerClass("text-primary font-yekan f16")
!!}

{!!
widget("input")
	->nameIf($locale=="fa" , "title")
	->nameIf($locale!="fa" , "_title_in_$locale")
	->label("tr:validation.attributes.title")
	->value($model->titleIn($locale))
	->requiredIf($locale=="fa")
	->inForm()
!!}

{!!
widget("input")
	->nameIf($locale=="fa" , "plural_title")
	->nameIf($locale!="fa" , "_plural_title_in_$locale")
	->label("tr:validation.attributes.plural_title")
	->value($model->pluralTitleIn($locale))
	->requiredIf($locale=="fa")
	->inForm()
!!}
