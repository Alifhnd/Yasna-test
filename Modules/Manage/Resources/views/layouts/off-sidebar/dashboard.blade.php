<div class="p onlyDesktop">
    <h4 class="text-muted text-thin font-yekan">{{ trans_safe("manage::template.dashboard_settings") }}</h4>
    <div class="">
        {!!
        widget("button")
            ->id('openDashboardWidget')
            ->name('openDashboardWidget')
        	->label("tr:manage::template.widgets_repository")
        	->class('btn-primary')
        	->onClick( "openDashboardRepository()" )
        !!}
    </div>


    {{--<div class="" ondblclick="divReload('column-repository')" data-content="no">--}}
        {{--<div id="column-repository" class="column" data-src="manage/widget-repository"></div>--}}
        {{--<div class="col-md-8">--}}
            {{--{{ trans_safe("manage::template.widgets_repository_hint") }}--}}
        {{--</div>--}}
    {{--</div>--}}

</div>
