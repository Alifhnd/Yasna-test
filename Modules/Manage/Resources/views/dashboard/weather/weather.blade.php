@inject('weather', 'Modules\Manage\Services\Weather\Weather')
@php
	// Available States: "clear-day", "clear-night", "partly-cloudy-day", "partly-cloudy-night", "cloudy",
	//	"rain", "sleet", "snow", "wind", "fog"
	$weather_state = [
		"value" => $weather->getIcon(),
		"title" => $weather->getStatus(),
	];
	$details = [
		[
			"icon" => "raindrops" ,
			"title" => trans('manage::dashboard.weather.humidity') ,
			"value" => $weather->getHumidity()."%" ,
		],
		[
			"icon" => "windy" ,
			"title" => trans('manage::dashboard.weather.wind_speed') ,
			"value" => $weather->getWindSpeed()." Km" ,
			"class" => "wind-speed" , 
		],
		[
			"icon" => "sunrise" ,
			"title" => trans('manage::dashboard.weather.sunrise') ,
			"value" => $weather->getSunrise() ,
		],
		[
			"icon" => "sunset" ,
			"title" => trans('manage::dashboard.weather.sunset') ,
			"value" => $weather->getSunset() ,
		],
	];
@endphp
@if($weather->hasData())
	<div class="weather-dashboard-widget">
		<div class="panel widget mb0">
			<div class="mb-lg" onclick="masterModal('{{ url('manage/weather/choose_state') }}' , 'md' )">
				<a href="{{ v0() }}" class="text-white">
					<em class="f20 fa fa-gear"></em>
				</a>
			</div>
			<div class="weather-container">
				<div class="text">
					<div class="h2">{{ $weather->getProvince() }}، {{ $weather->getCity() }}</div>
					<div class="date">{{ pd(jDate::forge($weather->getDate())->format('l ,j F Y ')) }}</div>
					<div class="f18 mv text-bold weather-state">{{ $weather_state['title']}}</div>
				</div>
				<div class="visual">
					<div data-skycon="{{ $weather_state['value'] }}" data-color="#fff" data-width="80" data-height="80"
						 class=""></div>
					<div class="temperature">
					<span>{{ ad($weather->getTemperature()) }}<span
								style="vertical-align: super; font-size: 20px; font-weight: 500;">°C</span></span>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				@foreach($details as $detail)
					@php( $class = (isset($detail['class']))? $detail['class'] : ""  )
					<div class="col-lg-6 mb">
						@include('manage::dashboard.weather.weather-detail-row',[
							"title" => $detail['title'] ,
							"icon" => $detail['icon'] ,
							"value" => $detail['value'] ,
							"class" => $class ,
						])
					</div>
				@endforeach
			</div>
		</div>
	</div>
@else
	<div class="weather-dashboard-widget">
		<div class="panel widget mb0">
			<div class="weather-container">
				<div class="h3">{{ trans('manage::dashboard.weather.na_data') }}</div>
				<div class="h5">{{ $weather->provinceName() }}، {{ $weather->cityName() }}</div>
			</div>
		</div>
	</div>
@endif


<script defer>
    $('[data-skycon]').each(function () {
        var element = $(this),
            skycons = new Skycons({'color': (element.data('color') || 'white')});

        element.html('<canvas width="' + element.data('width') + '" height="' + element.data('height') + '"></canvas>');

        skycons.add(element.children()[0], element.data('skycon'));

        skycons.play();
    });
</script>
