@extends('manage::layouts.template')

@section('content')
	<div id="widgetsContainer" data-src="manage/widget/refresh-col">
		@include('manage::index.widgets')
	</div>

	<div class="noDisplay">
		<button id="btnWidgetsSaved" data-notify="" data-message="{{ trans_safe("manage::template.widgets_saved") }}"
				data-options='{"status":"success"}'></button>
		<button id="btnWidgetsNotSaved" data-notify="" data-message="{{ trans_safe("manage::template.widgets_not_saved") }}"
				data-options='{"status":"danger"}'></button>
	</div>
@stop
