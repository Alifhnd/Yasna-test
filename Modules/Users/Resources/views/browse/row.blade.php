@include('manage::widgets.grid-rowHeader' , [
	'handle' => "selector" ,
	'refresh_url' => str_replace('-hashid-' , $model->hashid , $row_refresh_url) ,
])

@foreach( service('users:browse_headings')->read()  as $heading)
	<td>
		@include($heading['blade'])
	</td>
@endforeach

@include("manage::widgets.grid-actionCol"  , [
	'actions' => $controller->renderRowActions($model) ,
])