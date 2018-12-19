@extends('manage::layouts.template')


@section('content')
	@include("manage::downstream.tabs")

	@include("users::downstream.departments.browse-toolbar")

	@include("users::downstream.departments.grid")
@endsection

@section('html_header')
	<meta name="csrf_token" content="{{ csrf_token() }}">
@append

@section('html_footer')
	{!! Html::script(Module::asset('users:js/departments.min.js')) !!}
@append
