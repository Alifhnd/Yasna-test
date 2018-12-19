{{widget('modal')->label(trans('notifier::general.delete-driver-modal'))->target(route('notifier.driver.delete'))->validation(false)->id('delete_notifier_driver')}}

<div class="modal-body ltr">


	<div class="panel-cols mb">
		<label class="panel-col">
			{{ trans("notifier::general.driver-title") }}
		</label>
		<div class="panel-col-3">
			{!!
				widget('input')
				->name()
				->disabled()
				->value($driver->title)
			 !!}
		</div>

	</div>

	{!! widget('hidden')->name('id')->value($driver->id) !!}

</div>

<div class="modal-footer pv-lg ltr" style="text-align: left">
	{!! widget('feed') !!}
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('notifier::general.accept'))->class('btn-danger')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('notifier::general.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>