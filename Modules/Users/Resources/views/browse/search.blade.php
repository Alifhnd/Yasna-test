@extends('manage::layouts.template')

@section('content')
	@include('users::browse.tabs')
	@include('users::browse.toolbar')
	@include("users::browse.search-panel")
@endsection