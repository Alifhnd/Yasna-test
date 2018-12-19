@include('manage::widgets.grid-start')
@include('manage::widgets.api.grid-loop')
@include('manage::widgets.api.grid-null',[
	"meta" => $response['metadata'] ,
])
@include('manage::widgets.api.grid-end',[
	"meta" => $response['metadata'] ,
])
@include('manage::widgets.api.grid-paginate', [
	"meta" => $response['metadata'] ,
])
