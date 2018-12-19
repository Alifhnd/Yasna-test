@if( module('manage')->service('file_manager')->isset('single_photo') )
	@include( module('manage')->service('file_manager')->read()['single_photo']['blade'])
@else
	@include("manage::forms.input")
@endif