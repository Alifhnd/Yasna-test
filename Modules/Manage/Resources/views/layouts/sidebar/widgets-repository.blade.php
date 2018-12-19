<div class="widget-repository noDisplay" ondblclick="divReload('column-repository')" data-content="no">
    <header class="repo-header">
        <i class="fa fa-info-circle mr-sm" aria-hidden="true"></i>
        {{ trans_safe("manage::template.widgets_repository_hint") }}
    </header>
    {!!
        widget('button')
        ->id('closeDashboardWidget')
        ->label("tr:manage::forms.button.cancel")
        ->class('btn-danger btn-sm')
        ->onClick( "closeDashboardRepository()" )
     !!}
    {!!
        widget('separator')
     !!}
        <div id="column-repository" class="column repo-body" data-src="manage/widget-repository"></div>
</div>