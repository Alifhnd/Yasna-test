@extends('manage::layouts.template')

@section('content')
	@include("manage::account.tabs")

	@foreach(service("manage:account_personal_settings")->read() as $item)
		@include($item['blade'])
	@endforeach

	@if(!service("manage:account_personal_settings")->count())
		<div class="null">
			{{ trans('manage::forms.feed.nothing') }}
		</div>
	@endif

@endsection