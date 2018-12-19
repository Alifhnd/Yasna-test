<div class="bg-{{ $bg or 'gray' }} panel-body text-center">
	<div class="row row-table">

		@foreach($stats as $stat)
		<div class="col-xs-{{ $size or 4 }}">
			<h3 class="m0">
				{{ ad($stat['stat']) }}
			</h3>
			<p class="m0">
				{{ $stat['title'] }}
			</p>
		</div>
		@endforeach
	</div>
</div>
