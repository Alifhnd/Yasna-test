@if(!isset($condition) or $condition)
	@php
		// Revision: 14-Dec-2017, by Taha

		/*-----------------------------------------------
		| Class ...
		*/
		!isset($size)? $size = 12 : '' ;
		!isset($color)? $color = '' : '' ;
		!isset($class)? $class = '' : '' ;
		!isset($locale)? $locale=false : '' ;
		$class = " f".$size." text-$color $class" ;

		/*-----------------------------------------------
		| Target ...
		*/
		$link = manage()->parseLink(isset($link)? $link : 'NO', isset($model)? $model : null);
	@endphp



	<div id="{{$id or ''}}" class="{{ $div_class or '' }}" style="margin-bottom: 5px ;{{$div_style or ''}}">

		@if($link['set'])
			<a href="{{$link['href']}}" onclick="{{$link['js']}}" class="{{$class}}" target="{{$link['target']}}">
				@if(isset($icon))
					<i class="fa fa-{{$icon}} mhl5"></i>
				@endif
				{{ ad($text , $locale) }}
			</a>
		@else
			<span class="{{$class}}">
				@if(isset($icon))
					<i class="fa fa-{{$icon}} mhl5"></i>
				@endif
				<span class="text1 {{$class}}">
				{{ ad($text , $locale) }}
					@if(isset($text2) and $text != $text2)
						<span class="fa fa-angle-double-down clickable text-green"
							  onclick="$(this).parent().parent().children(' .text2 , .text1').toggle()"></span>
					@endif
				</span>
				@if(isset($text2))
					<span class="text2 {{$class}} noDisplay">
						{{ ad($text2 , $locale) }}
						@if(isset($text2) and $text != $text2)
							<span class="fa fa-angle-double-up clickable text-green"
								  onclick="$(this).parent().parent().children(' .text2 , .text1').toggle()"></span>
						@endif
				</span>
				@endif
			</span>
		@endif
	</div>




@endif