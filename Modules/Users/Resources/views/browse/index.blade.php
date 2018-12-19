@extends('manage::layouts.template')

@section('html_header')
	@foreach(service('users:browse_top_blade')->read() as $item)
		@include($item['blade'])
	@endforeach
@append

@section('content')
	@include('users::browse.tabs')
	@include('users::browse.toolbar')
	@include('users::browse.grid')
@endsection