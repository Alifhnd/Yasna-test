<div class="analog-clock">
    <canvas id="analogClock" width="200" height="200">
    </canvas>
</div>
<div class="dates">
    <div class="col-lg-6">
        <div class="today">
			<span class="today-piece  top  day">
				{{ jDate::forge(now())->format('l') }}
			</span>
            <span class="date-full">
            <span class="today-piece  middle  date">
	            {{ pd(jDate::forge(now())->format('j')) }}
            </span>
            <span class="separator">/</span>
            <span class="today-piece  middle  month">
	            {{ pd(jDate::forge(now())->format('F')) }}
            </span>
            <span class="separator">/</span>
            <span class="today-piece  bottom  year">
	            {{ pd(jDate::forge(now())->format('Y')) }}
            </span>
        </span>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="today ltr">
			<span class="today-piece  top  day">
				{{ now()->format('l') }}
			</span>
            <span class="date-full">
            <span class="today-piece  middle  date">
	            {{ now()->format('j') }}
            </span>
            <span class="separator">/</span>
            <span class="today-piece  middle  month">
	            {{ now()->format('F') }}
            </span>
            <span class="separator">/</span>
			
			<span class="today-piece  bottom  year">
	            {{ now()->format('Y') }}
            </span>
        </span>
        </div>
    </div>

</div>

<script>
    setInterval(showClock, 1000);
</script>

