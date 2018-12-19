@include('manage::widgets.api.grid-row-handle' , [
	'handle' => "counter" ,
])

@include($__module->getBladePath('support.list.row-title'))
@include($__module->getBladePath('support.list.row-flag'))
