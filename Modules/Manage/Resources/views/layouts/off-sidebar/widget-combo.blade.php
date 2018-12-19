<div class="p">
	<h4 class="text-muted text-thin font-yekan">{{ trans_safe("manage::template.dashboard_settings") }}</h4>

	{!!
		widget("button")
			->id('openDashboardWidget')
			->name('openDashboardWidget')
			->label("tr:manage::template.widgets_repository")
			->class('btn-primary mb start-setting-btn mv-lg btn-block')
			->onClick( "viewCombolist(this)" )
	!!}

	@php($options = module('manage')->widgetsController()->dashboardUnusedWidgetsForCombo())

	<div id="widgetSettingContainer" data-src="manage/widget/refresh-widget-setting">
		@include("manage::layouts.off-sidebar.widget-setting",[
			"options" => $options ,
			"view" => false ,
		])
	</div>

</div>