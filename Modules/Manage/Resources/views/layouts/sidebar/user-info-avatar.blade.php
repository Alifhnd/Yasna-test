<!-- User picture-->
@php
	if(function_exists('doc')){
		$avatar = getSetting('default-avatar');
		$avatarUrl = doc($avatar)->getUrl();
	}
@endphp

@include('manage::layouts.sidebar.user-picture',[
	'src'=>  Module::asset('manage:images/user/avatar-default.jpg'),
])