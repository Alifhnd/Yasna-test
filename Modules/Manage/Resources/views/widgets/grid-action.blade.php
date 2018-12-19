{{--
|--------------------------------------------------------------------------
| Inserts a dropdown action button
|--------------------------------------------------------------------------
| Parameters: $id AND $actions = [0:fa_icon , 1:caption , 2:link or js_command , 3:optional boolian condition]
--}}

<span class="dropdown">
	<button id="action{{$id}}" class="btn btn-{{$button_class or 'default'}} btn-{{$button_size or 'sm'}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" {{$button_extra or ''}}>
		<i class="fa fa-angle-down"></i>
		{{$button_label or trans('manage::forms.button.action')}}
	</button>
	<ul class="dropdown-menu animated flipInX" aria-labelledby="action{{$id}}" data-animate>
		@foreach($actions as $key => $action)
			@if($action[0]== '-')
				@if($action[1])
					<li>
						<hr class="mv5">
					</li>
				@endif
			@else
				<?php
					//first things first...
					$icon = $action[0] ;
					$caption = $action[1] ;
					$extra = null ;

					//target...
					$action[2] = str_replace('-id-' , $id , $action[2]);
					$action[2] = str_replace('-hash_id-' , hashid_encrypt($id,'ids') , $action[2]);
					$action[2] = str_replace('-hashid-' , hashid_encrypt($id,'ids') , $action[2]);
					if(str_contains($action[2],'(')) {
						$js_command = $action[2] ;
						$target = 'javascript:void(0)' ;
					}
					elseif(str_contains($action[2] , 'modal')) {
						$target = 'javascript:void(0)' ;
						$array = explode(':',$action[2]) ;
						if(!isset($array[2])) $array[2] = 'lg' ;
						$js_command = "masterModal('". url($array[1]) ."' , '". $array[2] ."' )" ;
					}
					elseif(str_contains($action[2] , 'url')) {
						$target = str_after($action[2],':') ;
						$js_command = null ;
						if(str_contains($action[2] , 'urlN'))
							$extra .= ' target="_blank" ';
					}
					else {
						$js_command = null ;
						$target = $action[2] ;
					}

					//condition...
					if(!isset($action[3]))
						$action[3] = true ;

				?>
				@if($action[3])
					<li>
						<a href="{{$target}}" onclick="{{$js_command}}" style="font-size: 12px" {{$extra}}>
							<i class="fa fa-{{$icon or 'circle'}} fa-fw" {{--style="position: relative;left: +10px"--}}></i>
							{!! $caption !!}
						</a>
					</li>
					{{--@if($key+1 < sizeof($actions))--}}
					{{--<li>--}}
						{{--<hr class="mv5">--}}
					{{--</li>--}}
					{{--@endif--}}
				@endif
			@endif
		@endforeach
	</ul>
</span>
