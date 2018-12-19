<ul class="nav nav-tabs" role="tablist">
	@foreach(service("users:permit_tabs")->read() as $key => $tab)
		{{--
		|--------------------------------------------------------------------------
		| Bypasses
		|--------------------------------------------------------------------------
		|
		--}}

		@if($loop->first)
			{{-- Nothing to do :) --}}
		@elseif($loop->last)

			@if(!count($modules))
				@continue
			@endif

		@elseif( !isset($modules[$key]) or user()->as('admin')->cannot($key) )
			@continue
		@endif


		{{--
		|--------------------------------------------------------------------------
		| Tabs
		|--------------------------------------------------------------------------
		|
		--}}

		<li role="presentation" class="{{ $loop->first? 'active' : '' }}"  >
			<a href="#div{{$key}}Permits" aria-controls="div{{$key}}Permits" role="tab" data-toggle="tab">
				@if(isset($tab['icon']))
					<i class="fa fa-{{$tab['icon']}} f16"></i>
				@endif
				@if(isset($tab['caption']))
					{{ $tab['caption'] }}
				@endif
			</a>
		</li>

		{{--
		|--------------------------------------------------------------------------
		| update $modules
		|--------------------------------------------------------------------------
		| This $modules is not the laravel-modules. It merely refers to the modules, define in roles
		--}}

		@php
			array_forget($modules , $key) ;
		@endphp

	@endforeach
</ul>
