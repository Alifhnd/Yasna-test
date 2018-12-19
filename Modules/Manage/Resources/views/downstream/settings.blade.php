@extends('manage::layouts.template')

@section('content')
	@include("manage::downstream.tabs")

	@include("manage::widgets.toolbar")

    <div class="container container-md">
		@include('manage::downstream.setting-search')

		<div id="setting_result_view" class="list-group" style="display: none;"></div>

		<div id="setting_category_view" style="display: block;">
			@foreach(model('setting')->getCategories() as $category)

				@include('manage::downstream.settings-row')

			@endforeach

			<div class="box-placeholder box-placeholder-lg text-center js_no-result" style="display: none;">
				{{ trans('manage::settings.result_not_found') }}
			</div>
		</div>
    </div>


@endsection

@section('html_footer')
	{!! Html::script(Module::asset('manage:js/search-setting.min.js')) !!}
@append
