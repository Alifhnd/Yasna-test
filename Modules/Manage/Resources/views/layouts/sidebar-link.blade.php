@php
	isset($condition) ?: $condition = true ;
	isset($id) ?: $id = "liSidebar-" . str_random(20) ;
	if(isset($permission)) {
		$authorized = user()->as('admin')->can($permission) ;
	}
	else {
		$authorized = true ;
	}
	$printed = 0 ;
@endphp


@if($condition and $authorized)

	@if(isset($class))
		@php $itemClass .= " $class" @endphp
	@endif
	<li id="{{$id}}" >

		{{--
		|--------------------------------------------------------------------------
		| Main Manu
		|--------------------------------------------------------------------------
		|
		--}}

		@if(isset($disabled) and $disabled)
			<a href="javascript:void(0)" class="null-content">
				<em class="fa fa-{{ $icon or 'dot-circle-o' }}"></em>
				<span>&nbsp;{{ $caption }}&nbsp;</span>
			</a>
		@elseif(isset($sub_menus))
			@php
				$link = str_random(15);
			@endphp
			<a href="{{ '#'.$link }}" data-toggle="collapse">
				@if(isset($badge_count))
					<div class="pull-right label label-{{ $badge_color or "info" }}">{{ pd($badge_count) }}</div>
				@endif
				<em class="fa fa-{{ $icon or 'dot-circle-o' }}"></em>
				<span>&nbsp;{{ $caption }}&nbsp;</span>
				{{--@if(isset($sub_menus))
					<span class="fa arrow"></span>
				@endif--}}
			</a>
		@else
			<a href="{{ url ('manage/'.$link) }}">
				@if(isset($badge_count))
					<div class="pull-right label label-{{ $badge_color or "info" }}">{{ pd($badge_count) }}</div>
				@endif
				<em class="fa fa-{{ $icon or 'dot-circle-o' }}"></em>
				<span>&nbsp;{{ $caption }}&nbsp;</span>
				{{--@if(isset($sub_menus))
					<span class="fa arrow"></span>
				@endif--}}
			</a>
		@endif

		{{--
		|--------------------------------------------------------------------------
		| Sub Menus
		|--------------------------------------------------------------------------
		|
		--}}

		@if(isset($sub_menus))

			<ul id="{{ $link }}" class="nav sidebar-subnav collapse">
				<li class="sidebar-subnav-header">{{$caption}}</li>

				@foreach($sub_menus as $sub_menu)

					@if(isset($sub_menu['permit']) and is_string($sub_menu['permit']))
						@php
							user()->stringCheck($sub_menu['permit']); //<~~ Strange thing! But necessary for the good operation of the below line!
                                   $sub_menu['permit'] = user()->stringCheck($sub_menu['permit']);
						@endphp
					@endif

						@php
							isset($sub_menu['permit'])?: $sub_menu['permit'] = true;
							isset($sub_menu['condition'])?: $sub_menu['condition'] = true;
						@endphp

					@if($sub_menu['permit'] and $sub_menu['condition'])
							@php
								$printed++;
							@endphp

						<li {{ (Request::is('*'.$sub_menu['link']) ? 'class="active"' : '') }}>
							<a href="{{ url ("manage/".$sub_menu['link']) }}">
								@if(isset($badge))
									<div class="pull-right label label-{{ $badge_color or "success" }}">{{ pd($badge_count) }}</div>
								@endif
								{{--<i class="fa fa-{{ $sub_menu['icon'] or 'dot-circle-o' }} fa-fw" style="width: 20px"></i>--}}
								&nbsp;<span>{{ $sub_menu['caption'] }}&nbsp;</span>
							</a>
						</li>
					@endif

				@endforeach
			</ul>

			@if(!$printed)
				<script>$('#{{ $id }}').hide();forms_log(1)</script>
			@endif

		@endif

	</li>


@endif
