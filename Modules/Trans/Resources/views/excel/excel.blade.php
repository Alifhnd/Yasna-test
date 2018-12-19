<table>
	<tr>
		<td>key</td>
		@foreach($header as $lang)
			<td>{{ $lang }}</td>
		@endforeach
	</tr>
	@foreach($rows as $row)
		<tr>
			@foreach($row as $column)
				<td>{{ $column }}</td>
			@endforeach
		</tr>
	@endforeach
</table>
