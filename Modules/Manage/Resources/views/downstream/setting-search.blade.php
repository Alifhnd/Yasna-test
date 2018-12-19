<div class="form-horizontal mb-xl mt-lg">
	<div class="row">
		<div class="col-md-12" style="float: none; margin: 0 auto;">
			{!!
				widget('input')
				->addon('tr:manage::settings.search')
				->class('search-setting-js input-lg')
			 !!}
		</div>
	</div>
</div>

{{--<script id="setting_json_value" data-value='{!! json_encode($models->toJson()) !!}'--}}
		{{--data-alert-message="{{ trans('manage::settings.result_not_found') }}"></script>--}}
