@php
	$stats = [
		[
			"stat" => "400" ,
			"title" => "پست" ,
		],
		[
			"stat" => "50" ,
			"title" => "فایل" ,
		],
		[
			"stat" => "1236" ,
			"title" => "نظر" ,
		],
	];
@endphp


@include('users::profile.widgets.stats',[
     "stats" => $stats ,
     "bg" => "inverse" , 
])
