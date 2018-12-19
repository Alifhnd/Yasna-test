@php
	$cards = [
		[
			"color" => "primary" , 
			"count" => "30" , 
			"title" => "خرید از ما" , 
			"link" => "#" , 
			"icon" => "shopping-cart" , 
		],	
		[
			"color" => "purple" , 
			"count" => "100" , 
			"title" => "تیکت‌ها" ,
			"link" => "#" , 
			"icon" => "support" ,
		],	
		[
			"color" => "green" ,
			"count" => "20" , 
			"title" => "نظرات" , 
			"link" => "#" , 
			"icon" => "comments" ,
		],
	];
@endphp

<div class="mh15">
	<div class="row">
		@foreach($cards as $card)
			<div class="col-sm-4">
				@include('users::profile.widgets.card',[
				"color" => $card['color'] ,
				"count" => $card['count'] ,
				"title" => $card['title'] ,
				"link" => $card['link'] ,
				"icon" => $card['icon'] ,
			])
			</div>
		@endforeach	
	</div>
</div>

