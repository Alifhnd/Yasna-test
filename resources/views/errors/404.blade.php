{{--
|--------------------------------------------------------------------------
| If modules does not exist
|--------------------------------------------------------------------------
|
--}}

@if(!function_exists('module'))
	@extends('errors::layout')
	@section('title', 'Page Not Found')
@section('message', 'Sorry, the page you are looking for could not be found.')
{{ die() }}
@endif

{{--
|--------------------------------------------------------------------------
| Looking into the service
|--------------------------------------------------------------------------
|
--}}
@php
    $blade = module('yasna')->service('errors')->find('404')->get('blade');
@endphp

@if($blade)
	@include($blade)
@else
	@extends('errors::layout')
	@section('title', 'Page Not Found')
@section('message', 'Sorry, the page you are looking for could not be found.')
@endif
