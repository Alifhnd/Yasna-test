<div class="clearfix mh mt-xl">
	<h3 class="text-thin pull-left mt0">
		{{ trans('manage::settings.title') }}
	</h3>
</div>

@include("manage::layouts.off-sidebar.themes")
@if(Request::is('manage/dashboard') or Request::is('manage'))
	{{--@include("manage::layouts.off-sidebar.dashboard")--}}

	@include("manage::layouts.off-sidebar.widget-combo")
@endif
