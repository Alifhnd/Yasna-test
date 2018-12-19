{{widget('modal')->label(trans('trans::downstream.excel.import'))->target(route('manage.trans.import')) }}

<div class="modal-body">
	<label for="modules">{{ trans('trans::downstream.excel.choose_file') }}</label>

	<div class="form-group ">
		<div class="col-sm-12">
			<input type="file" id="file" name="file" class="form-control" required>
			<span class="help-block"></span>
		</div>
	</div>

	<br>
</div>
@include("manage::widgets101.feed",['container_id'=>"",'container_class'=>'','container_style'=>''])

<br>
<div class="modal-footer pv-lg">
	{!! widget('button')->type('submit')->id('edit-btn')->label(trans('trans::downstream.accept'))->class('btn-success')!!}
	{!! widget('button')->id('cancel-btn')->label(trans('trans::downstream.cancel'))->class(' btn-link btn-taha ')->onClick('$(".modal").modal("hide")')!!}

</div>
