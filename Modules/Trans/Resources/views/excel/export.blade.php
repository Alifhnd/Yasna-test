{{widget('modal')->label(trans('trans::downstream.excel.get_export_from_tans'))->target(route('manage.trans.export'))}}

<div class="modal-body">

	<label for="modules">{{ trans('trans::downstream.excel.choose_module') }}</label>
	{{
	widget('selectize')
	->name('modules')
	->id('modules')
	->value($modules_name)
	->options($modules)
	->captionField('caption')
	->valueField('value')
	}}
	<br>
	<label for="locales">{{ trans('trans::downstream.excel.choose_locale') }}</label>
	{{
	widget('selectize')
	->name('locales')
	->id('locales')
	->value($locales_name)
	->options($locales)
	->captionField('caption')
	->valueField('value')
	}}
</div>

<br>
<div class="modal-footer pv-lg">
	{!! widget('button')->type('submit')->id('edit-btn')->label(trans('trans::downstream.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('trans::downstream.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>
