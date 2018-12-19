@foreach($array as $widget_name)
	@if($widget_name)
		@include("manage::index.panel" , [
			'fake' => $index = str_after($widget_name , $id_prefix) ,
			'widget' => isset($widgets[$index]) ?  $widgets[$index] : false,
			'defer' => "true" ,
		])
	@endif
@endforeach
