@extends('yasna::errors.mini_template')
@section('error_code')
	{{ $error = 404 }}
@endsection
@section('message')
	{{ trans("validation.http.Error".$error) }}
@endsection