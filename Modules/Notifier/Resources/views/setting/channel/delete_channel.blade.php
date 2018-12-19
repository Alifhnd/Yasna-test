{{widget('modal')->label(trans('notifier::general.delete-channel-modal'))->target(route('notifier.channel.delete'))->validation(false)->id('delete_notifier_channel')}}

<div class="modal-body ltr">


	<div class="panel-cols mb">
		<label class="panel-col">
			{{ trans("notifier::general.channels") }}
		</label>
		<div class="panel-col-3">
			{!!
				widget('input')
				->name()
				->disabled()
				->value($name)
			 !!}
		</div>

	</div>

	{!! widget('hidden')->name('name')->value($name) !!}

</div>

<div class="modal-footer pv-lg ltr" style="text-align: left">
	{!! widget('feed') !!}
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('notifier::general.accept'))->class('btn-danger')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('notifier::general.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>