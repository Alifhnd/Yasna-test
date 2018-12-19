@if(isset($refresh_url))
	<td class="refresh">{{ url($refresh_url) }}</td>
@endif
@if(isset($handle) and str_contains($handle , 'selector'))
	<td>
		{!!
			widget('checkbox')
			->id("gridSelector-$data[id]")
			->setExtra('data-value',$data['id'])
			->class('gridSelector')
			->onChange("gridSelector('selector','$data[id]')")
		 !!}
	</td>
@endif
@if(isset($handle) and str_contains($handle , 'counter'))
	<td class="-rowCounter">
		@if(isset($i))
			@pd($i+1)
		@endif
	</td>
@endif
<script>
	@if($data['is_trashed'] ?? false)
    	$("#tr-{{ $data['id'] }}").addClass('deleted-content');
	@else
    	$("#tr-{{ $data['id'] }}").removeClass('deleted-content');
	@endif
</script>
