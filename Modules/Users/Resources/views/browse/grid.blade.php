@include("manage::widgets.grid" , [
	'table_id' => "tblUsers" ,
	'row_view' => module('users')->viewName('browse.row') ,
	'handle' => "selector" ,
	'operation_heading' => true ,
	'headings' => service('users:browse_headings')->indexed('caption' , 'width' , 'condition' , 'blade') ,
]     )
