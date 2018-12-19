@foreach($widgets as $key => $widget)
	@include("manage::index.panel" , [
		'minimized' => true ,
	])
@endforeach
