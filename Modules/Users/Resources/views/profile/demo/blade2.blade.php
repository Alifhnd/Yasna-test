@php
	$cards = [
		[
			"color" => "info" ,
			"count" => "30" , 
			"title" => "خرید از ما" , 
			"icon" => "shopping-cart" ,
		],	
		[
			"color" => "danger" ,
			"count" => "100" , 
			"title" => "تیکت‌ها" ,
			"icon" => "support" ,
		],	
		[
			"color" => "success" ,
			"count" => "20" , 
			"title" => "نظرات" , 
			"icon" => "comments" ,
		],
		[
			"color" => "warning" ,
			"count" => "20" ,
			"title" => "نظرات" ,
			"icon" => "comments" ,
		],
	];
@endphp

<div class="mv40 mh15">
	<div class="row">
		@foreach($cards as $card)
			<div class="col-sm-6">
				@include('users::profile.widgets.card',[
				"color" => $card['color'] ,
				"count" => $card['count'] ,
				"title" => $card['title'] ,
				"icon" => $card['icon'] ,
			])
			</div>
		@endforeach	
	</div>
</div>

