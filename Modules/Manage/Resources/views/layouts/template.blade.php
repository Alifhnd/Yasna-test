@extends('manage::layouts.master')

@section('sidebar')
	@include("manage::layouts.sidebar")
@endsection






@section('page_title')
	@if(isset($page[0][1]))
		{{$page[0][1]}} |&nbsp;
	@endif
	{{ setting('site_title')->gain() }}
@endsection






@section('modal')
	@foreach( service('manage:modals')->read() as $modal )
		@include($modal['blade'])
	@endforeach
@endsection