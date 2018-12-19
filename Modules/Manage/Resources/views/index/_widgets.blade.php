@php
	$widgets = module('manage')->widgetsController()->dashboardAvailableWidgets();
	$saved = module('manage')->widgetsController()->dashboardSavedWidgets();
	$id_prefix = "divWidget-";
@endphp

{{--
|--------------------------------------------------------------------------
| Normal Columns
|--------------------------------------------------------------------------
|
--}}

<div class="row">
	@include("manage::index.panels" , [
		'identifier' => "big" ,
		'size' => "7" ,
	])
	@include("manage::index.panels" , [
		'identifier' => "small" ,
		'size' => "5" ,
	])
	@include("manage::index.panels" , [
		'identifier' => "even1" ,
		'size' => "6" ,
	])
	@include("manage::index.panels" , [
		'identifier' => "even2" ,
		'size' => "6" ,
	])
</div>

{{--
|--------------------------------------------------------------------------
| Repository Column
|--------------------------------------------------------------------------
|
--}}

{{--<div class="row noDisplay" ondblclick="divReload('column-repository')" data-content="no">
	<div id="column-repository" class="column col-md-4" data-src="manage/widget-repository"></div>
	<div class="col-md-8">
		{{ trans_safe("manage::template.widgets_repository_hint") }}
	</div>
</div>--}}

<div class="noDisplay">
	<button id="btnWidgetsSaved" data-notify="" data-message="{{ trans_safe("manage::template.widgets_saved") }}"
			data-options='{"status":"success"}'></button>
	<button id="btnWidgetsNotSaved" data-notify="" data-message="{{ trans_safe("manage::template.widgets_not_saved") }}"
			data-options='{"status":"danger"}'></button>
</div>