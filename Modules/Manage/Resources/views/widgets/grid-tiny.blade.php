<?php
//class...
!isset($size) ? $size = 11 : '';
!isset($color) ? $color = 'grey' : '';
!isset($class) ? $class = '' : '';
!isset($style) ? $style = '' : '';
!isset($locale) ? $locale = false : '';
$class = " f" . $size . " text-$color $class";

//target...
$link = manage()->parseLink(isset($link)? $link : 'NO', isset($model)? $model : null);

?>
@if(!isset($condition) or $condition)
	<div class="{{ $div_class or '' }}" style="{{$div_style or ''}}">
		@if($link['set'])
			<a href="{{$link['href']}}" onclick="{{$link['js']}}" class="{{$class}}" style="{{$style}}" target="{{$link['target']}}">
				<i class="fa fa-{{$icon or 'hand-o-left'}} mhl5"></i>
				{{ ad($text , $locale) }}
			</a>
		@else
			<span class="{{$class}}" style="{{$style}}">
				<i class="fa fa-{{$icon or 'hand-o-left'}} mhl5"></i>
				{{ ad($text , $locale) }}
			</span>
		@endif
	</div>

@endif
