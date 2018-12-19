@php
	$result = [] ;
	foreach($headings as $key => $heading) {
		$result[$key] = [
			'condition' => true ,
			'caption' => $heading ,
			'width' => "" ,
			'class' => "" ,
		];

		if(is_array($heading)) {
			$switches = $heading ; // <~~ 1:width/class 2:condition <~~

			$result[$key]['caption'] = $switches[0] ;

			if(isset($switches[1])) {
				if(is_numeric($switches[1])) {
					$result[$key]['width'] = $switches[1] ;
				}
				else {
					$result[$key]['class'] = $switches[1];
				}
			}
			if(isset($switches[2])) {
				$result[$key]['condition'] = $switches[2];
			}

		}

		if($result[$key]['caption'] == 'NO' or !$result[$key]['condition']) {
			unset($result[$key]);
			continue ;
		}
	}
@endphp

@foreach($result as $item)
	<td width="{{ $item['width'] }}" class="{{ $item['class'] }}">{{$item['caption']}}</td>
@endforeach


@if(isset($operation_heading) and $operation_heading)
	<td width="100">{{ trans('manage::forms.button.action') }}</td>
@endif
