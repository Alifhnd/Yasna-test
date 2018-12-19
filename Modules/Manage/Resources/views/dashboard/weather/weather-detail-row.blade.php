<div class="weather-data-row {{ $class or "" }}">
	<div class="row mb5">
		<div class="col-xs-5 title">
			<i class="wi wi-{{ $icon }} mr-sm"></i>
		</div>
		<div class="col-xs-7 text-left text" style="direction: ltr;">
			{{ ad($value) }}
		</div>
	</div>
</div>
