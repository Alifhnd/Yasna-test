<h4>{{ $title }}</h4>

{!! $body !!}

@if(isset($attached_files) and count($attached_files))
	<div class="p10 bg-gray-lighter well mt-lg">
		<ul class="list-unstyled">
			@foreach($attached_files as $attached_file)
				<li>
					<a href="{{ $attached_file }}" target="_blank">
						<i class="fa fa-download mr-sm"></i>
						{{ trans('manage::support.attach'). " " . ad($loop->iteration) }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>

@endif

@if(isset($labels) and count($labels))
	<div class="mv-sm">
		@foreach($labels as $label)
			@include('manage::widgets.grid-badge',[
				"color" => $label['color'] ,
				"text" => $label['text'] ,
			])
		@endforeach
	</div>
@endif
