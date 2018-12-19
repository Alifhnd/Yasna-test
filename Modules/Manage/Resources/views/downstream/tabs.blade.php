@if(count($tabs) > 1)
	@include("manage::widgets.tabs" , [
		'current' => $page[1][0] ,
		'tabs' => $tabs ,
	])
@endif