@if(!isset($saved["column-$identifier"]))
	@php
		$saved["column-$identifier"] = [];
	@endphp
@endif

<div class="column col-md-{{$size}}" id="{{ "column-$identifier" }}" data-src="manage/widget/refresh-col/{{$identifier}}">
	@include("manage::index.panels-inside" , [
		'array' => $saved["column-$identifier"] ,
		"editable" => false ,
	])
</div>
