@foreach($response['results'] as $i => $data)
	<tr id="tr-{{ $data['id'] }}" class="grid {{ ( isset($data['is_trashed']) and $data['is_trashed'] )? "deleted-content" : "" }}"
		@if(isset($handle) and str_contains($handle , 'selector'))
		ondblclick="gridSelector('tr','{{ $data['id'] }}')"
			@endif
	>
		@include($row_view , ['data'=> $data])
	</tr>
@endforeach
