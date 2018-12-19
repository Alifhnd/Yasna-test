@extends('manage::layouts.template')

@section('content')
    @include("manage::upstream.tabs")
    @include("users::upstream.roles.browse.toolbar")
    @include("users::upstream.roles.browse.grid")
@endsection
