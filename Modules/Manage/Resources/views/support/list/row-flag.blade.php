<td>
	@php $flag_info = yasnaSupport()->getFlagInfo($data['flag']) @endphp
	@include('manage::widgets.grid-badge', [
		'text' => $flag_info['title'],
		'color' => $flag_info['color'],
		'icon'=> $flag_info['icon'],
		'condition' => !empty($flag_info),
	])
</td>
