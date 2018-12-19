<?php
	//class...
	!isset($size)? $size = 11 : '' ;
	!isset($color)? $color = '' : '' ;
	!isset($class)? $class = '' : '' ;
	!isset($icon)? $icon = 'check' : '' ;
	!isset($opacity)? $opacity = '0.8' : '' ;
	$class = " f".$size." text-$color $class" ;

	//target...
	if(isset($link) and $link) {
		if(isset($model)) {
			$link = str_replace('-id-' , $model->id , $link);
			$link = str_replace('-hash_id-' , $model->hashid , $link);
			$link = str_replace('-hashid-' , $model->hashid , $link);
	    }
		$extra = '' ;
		if(str_contains($link,'(')) {
			$js_command = $link ;
			$target = 'javascript:void(0)' ;
		}
		elseif(str_contains($link , 'modal')) {
			$target = 'javascript:void(0)' ;
			$array = explode(':',$link) ;
			if(!isset($array[2])) $array[2] = 'lg' ;
			$js_command = "masterModal('". url($array[1]) ."' , '". $array[2] ."' )" ;
		}
		elseif(str_contains($link , 'url')) {
			$array = explode(':',$link) ;
			$target = url($array[1]) ;
			$js_command = null ;
			if(str_contains($link , 'urlN'))
				$extra .= ' target="_blank" ';
		}
		else {
			$js_command = null ;
			$target = $link ;
		}
	}


?>
@if(!isset($condition) or $condition)
	<label id="{{$id or ''}}" class="badge badge-custom bg-{{$color}}">
		@if(isset($link) and $link)
			<a href="{{$target}}" onclick="{{$js_command}}" class="{{ classRemover($class, "text") }}" {{$extra}}>
				@if(isset($icon) and $icon)
					<i class="fa fa-{{$icon}}"></i>
				@endif
				@pd($text)
			</a>
		@else
			<span class="{{ classRemover($class, "text") }}">
				@if(isset($icon) and $icon)
					<i class="fa fa-{{$icon}}"></i>
				@endif
				@pd($text)
			</span>
		@endif
	</label>

@endif
