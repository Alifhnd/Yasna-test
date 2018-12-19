@if(!isset($condition) or $condition)
	@php
		// Revision: 28-Aug-2017, by Taha

		/*-----------------------------------------------
		| Target ...
		*/
		$target = v0() ;
		$js_command = '' ;
		$extra = '' ;
		$has_link = false ;
		$color = 'gray' ;

		if(isset($link) and $link and $link!='NO') {
			$color = '' ;
			$has_link = true ;
			if(isset($model)) {
				$link = str_replace('-id-' , $model->id , $link);
				$link = str_replace('-hash_id-' , $model->hash_id , $link);
				$link = str_replace('-hashid-' , $model->hash_id , $link);
			}

			if(str_contains($link,'(')) {
				$js_command = $link ;
				$target = 'javascript:void(0)' ;
			}
			elseif(str_contains($link , 'modal')) {
				$target = 'javascript:void(0)' ;
				$array = explode(':',$link) ;
				if(!isset($array[2])) {$array[2] = 'lg' ;}
				$js_command = "masterModal('". url($array[1]) ."' , '". $array[2] ."' )" ;
			}
			elseif(str_contains($link , 'url')) {
				$array = explode(':',$link) ;
				$target = url($array[1]) ;
				$js_command = null ;
				if(str_contains($link , 'urlN'))
					{$extra .= ' target="_blank" ';}
			}
			elseif($link == '') {
				$js_command = null ;
				$target = null ;
			}
			else {
				$js_command = null ;
				$target = $link ;
			}

		}
	@endphp


	{{--
	|--------------------------------------------------------------------------
	| With Link
	|--------------------------------------------------------------------------
	|
	--}}

	@if($has_link)

		<div class="col-masonry">
			<div class="panel b mb0">
				<div class="panel-body text-center p25">
					<a href="{{ $target }}" class="link-unstyled text-{{ $color or ""}}" onclick="{{ $js_command }}"
					   onmousemove="$(this).css('opacity','1')" onmouseout="$(this).css('opacity','0.9')"
							{{$extra}}
					>
						<em class="fa fa-4x fa-{{ $icon or "file-o" }} mv"></em>
						<hr>
						<h4>{{ $title }}</h4>
						@if( isset($caption) )
							<br>
							<small class="text-muted">
								{{ $caption }}
							</small>
						@endif
					</a>
				</div>
			</div>
		</div>


	@else

		<div class="col-masonry">
			<div class="panel b mb0">
				<div class="panel-body text-center p25">
					<em class="fa fa-4x fa-{{ $icon or "file-o" }} mv"></em>
					<hr>
					<h4>{{ $title }}</h4>
					@if( isset($caption) )
						<br>
						<small class="text-muted">
							{{ $caption }}
						</small>
					@endif
				</div>
			</div>
		</div>

	@endif
@endif
