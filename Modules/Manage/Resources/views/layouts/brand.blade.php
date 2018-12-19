<a class="navbar-brand" href="{{ url ('/') }}">
	{{ setting('site_title')->gain() }}
</a>


<span class="navbar-brand">/</span>


<a class="navbar-brand navbar-brand-sub" href="{{ url ('/manage') }}">
	{{ trans('manage::template.title') }}
</a>

@php
	$trans = $link = "manage";
@endphp

@if(isset($page))
	@foreach($page as $i => $p)
		@php
		$trans .= ".$p[0]";
		$link .= "/$p[0]";
		@endphp

		 <span class="navbar-brand">/</span>
		 <a class="navbar-brand navbar-brand-sub" href="{{ isset($p[2])? url('manage/'.$p[2]) : url($link) }}">
			 @if(isset($p[1]))
				 {{ $p[1] }}
			 @else
				 {{ trans("$trans.trans") }}
			 @endif
		 </a>
	@endforeach
@endif
