@php
	isset($minimized)?: $minimized = false ;
	isset($defer)?: $defer = false ;
	isset($widget['color'])?: $widget['color'] = 'primary' ;
	$display_color = ($minimized? 'default' : $widget['color']) ;
@endphp

@if($widget != false and isset($widget['key']))
	<div id="{{ $id = $id_prefix.$widget['key'] }}" class="grid-stack-item" data-gs-id="{{ $id = $grid['id'] }}" data-gs-x="{{ $grid['x'] or "0" }}" data-gs-y="{{ $grid['y'] or "0" }}" data-gs-width="{{ $grid['width'] or "3" }}" data-gs-height="{{ $grid['height'] or "4" }}">
		<div class="grid-stack-item-content panel panel-{{$display_color}} mb0">
			<div id="{{$id}}-panel" class="inner-content panel-{{$display_color}}" data-color="{{ $widget['color'] }}">

				<div class="panel-heading" style="cursor: move">
					<em class="fa fa-{{$widget['icon'] or 'snowflake-o'}}"></em>
					<span class="mh5">{{ $widget['caption'] or null }}</span>
					<em id="{{$id}}-refresh" class="fa fa-refresh pull-right clickable refresh-widget-button {{$editable? 'noDisplay' : ''}}"
						style="opacity: 0.3"
						onclick="divReload('{{ $id }}-body')"></em>
					<em id="{{$id}}-remove" class="f18 fa fa-times pull-right remove-widget-button clickable {{$editable? '' : 'noDisplay'}}"
						style="opacity: 0.3;"
						onclick="RemoveDashboradWidget(this)"></em>
				</div>

				<div id="{{$id}}-body" class="panel-body {{$minimized? 'noDisplay' : ''}}"
					 data-content="{{$minimized? 'no' : ''}}"
					 data-src="manage/widget-refresh/{{ $widget['key'] }}"
					 data-src-callback="setWidgetHeightWithDelay($('#{{$id}}'))">

					@if(!$minimized)
						@if($defer)
							@include('manage::index.defer' , compact('widget'))
						@else
							@include($widget['blade'] , compact('widget'))
						@endif
					@endif

				</div>

			</div>
		</div>
	</div>
@endif
