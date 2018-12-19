{{widget('modal')->label(trans('notifier::general.add-modal'))->target(route('notifier.channel.add'))->validation(false)->id('add_notifier_driver')}}

<div class="modal-body ltr">


	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.channels") ,
							"name" =>"channel",
							"value" => "" ,
						])

	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.driver-title") ,
							"name" =>"driver_title",
							"value" => "" ,
						])

	@include('notifier::setting.form.input',[
							"label" => trans("notifier::general.driver-name") ,
							"name" =>"driver_name",
							"value" => "" ,
						])
<div>
	@include('notifier::setting.form.input',[
						"label" => trans("notifier::general.fields") ,
						"name" =>"fields_name",
						"value" => "" ,
					])
</div>


</div>

<div class="modal-footer pv-lg ltr" style="text-align: left">
	{!! widget('feed') !!}
	{!! widget('button')->type('submit')->id('add-btn')->label(trans('notifier::general.add'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('notifier::general.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>