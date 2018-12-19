{{--
428 Precondition Required (RFC 6585)
The origin server requires the request to be conditional.
Intended to prevent the 'lost update' problem, where a client
GETs a resource's state, modifies it, and PUTs it back to the server,
when meanwhile a third party has modified the state on the server, leading to a conflict."
--}}

@extends('yasna::Amirhossein.Resources.views.errors.full_template')
@section('error_code')
	{{ $error = 424 }}
@endsection
@section('message')
	{{ trans("validation.http.Error".$error) }}
	<div class="mv10 f16">
		{{ $message or trans('manage::template.tell_developers') }}
	</div>
@endsection