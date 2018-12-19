{{widget('modal')->label(trans('notifier::general.edit-driver-modal'))->target(route('notifier.driver.edit'))->validation(false)->id('edit_notifier_driver')}}

<div class="modal-body ltr">

	{!! widget('hidden')->name('id')->value($driver->id) !!}

	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.driver-title") ,
							"name" =>"driver_title",
							"value" => $driver->title ,
						])

	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.driver-name") ,
							"name" =>"driver_name",
							"value" => $driver->driver ,
						])
	<div>
		@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.fields") ,
							"name" =>"fields_name",
							"value" => implode(' , ',array_keys((array) $driver->getMeta('data'))) ,
						])
	</div>


</div>

<div class="modal-footer pv-lg ltr" style="text-align: left">
	{!! widget('feed') !!}
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('notifier::general.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('notifier::general.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}
</div>