<div class="tab-content">
	@foreach(service("users:permit_tabs")->read() as $key => $tab)
		<div role="tabpanel" class="tab-pane p20 {{$loop->first? 'active' : ''}}" id="div{{$key}}Permits">
			@include($tab['blade'])
		</div>
	@endforeach
</div>