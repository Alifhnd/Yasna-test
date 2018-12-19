<div class="combo-container {{$view? '' : 'noDisplay'}}">
    @if(count($options) >0)
        
        {!!
        widget('formOpen')
        ->class('js mt-xl')
        ->target("name:dashboard-widget-add")
     !!}
        
        {!!
    
             widget('combo')
                 ->id('combowidget')
                 ->name('widget')
                 ->options($options)
                 ->searchable()
                 ->valueField('key')
                 ->captionField('caption')
                 ->blankValue('')
         !!}
        
        {!!
            widget("button")
                ->id('addWidget')
                ->type('submit')
                ->name('addWidget')
                ->label("tr:manage::template.add_widget")
                ->class('btn-success mt')
    
        !!}
        
        {{--{!!--}}
        {{--widget("feed")--}}
        {{--!!}--}}
        
        {!!
            widget('formClose')
         !!}
        @else
        <div class="col-md-12 bg-gray-light p10 mt">
            {{ trans('manage::dashboard.setting.message.empty') }}
        </div>
        @endif
    

    {!!
     widget("button")
         ->id('endWidgetSetting')
         ->name('endWidgetSetting')
         ->label("tr:manage::template.end_setting")
         ->class('btn-default mt-xl')
         ->style('width:100%;')
         ->onClick( "endWidgetSetting()" )
 !!}

</div>