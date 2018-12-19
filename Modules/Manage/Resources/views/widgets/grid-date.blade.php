<?php
//class...
isset($size) ?: $size = 10;
isset($color) ?: $color = 'gray';
isset($class) ?: $class = 'link-unstyled';
isset($default) ?: $default = 'relative';
isset($inline) ?: $inline = false;
isset($format) ?: $format = 'j F Y [H:i]';
$class = " f" . $size . " text-$color $class";
?>

@if(!isset($condition) or $condition)
	@if(!$inline)
		<div>
			@endif

			<span class="">
				@if(is_null($date) and isset($dash_if_empty) and $dash_if_empty)
					<text class="{{ $class or '' }}" style="color:inherit">
						-
					</text>
				@else
					<a id="{{ $id = "spnDate".rand(10000,99999) }}" href="javascript:void(0)" class="{{$class}}"
					   onclick="$('#{{$id}} text').toggle()">
						<i class="fa fa-{{$icon or 'clock-o'}} mhl5" style="color:inherit"></i>
						{{$text or '' }}
						<text class="{{ $default=='fixed'?'noDisplay':'' }} {{$class or ''}}" style="color:inherit">
							{{ pd(jDate::forge($date)->ago() ) }}
						</text>
						<text class="{{ $default=='relative'?'noDisplay':'' }} {{$class or ''}}" style="color:inherit">
							{{ pd(jDate::forge($date)->format($format)) }}
						</text>
						{{ $text2 or '' }}
					</a>
					@if(isset($by))
						<span class="{{$class}}">&nbsp;{{ trans('manage::forms.general.by') }}&nbsp;{{ $by }}</span>
					@endif
				@endif
	</span>

			@if(!$inline)
		</div>
	@endif

@endif
