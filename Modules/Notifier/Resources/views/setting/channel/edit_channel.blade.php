{{widget('modal')->label(trans('notifier::general.edit-channel-modal'))->target(route('notifier.channel.edit'))->validation(false)->id('edit_channel_channel')}}

<div class="modal-body ltr">

	{!! widget('hidden')->name('pre_name')->value($name) !!}

	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.channels") ,
							"name" =>"channel",
							"value" => $name ,
						])

</div>

<div class="modal-footer pv-lg ltr" style="text-align: left">
	{!! widget('feed') !!}
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('notifier::general.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('notifier::general.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}
</div>