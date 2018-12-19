@php
	$saved = module('manage')->widgetsController()->dashboardSavedWidgets();
	$widgets = module('manage')->widgetsController()->dashboardAvailableWidgets();
	$id_prefix = "divWidget-";

	$editable = false;
@endphp

<div class="grid-stack" data-gs-width="12" data-gs-animate="yes">
	@foreach($saved as $widget)
		@if($widget)
			@include("manage::index.panel" , [
				'fake' => $index = str_after($widget['id'] , $id_prefix) ,
				'widget' => isset($widgets[$index]) ?  $widgets[$index] : false,
				'defer' => "true" ,
				"grid" => $widget ,
			])
		@endif
	@endforeach
</div>

<script>
	$(document).ready(function () {
        initWidgetGrid('{!! json_encode($saved) !!}');
    })
</script>
