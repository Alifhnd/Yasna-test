{{--
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
| Fixed at the top of the menu
--}}
@include('manage::layouts.sidebar-link' , [
	'icon' => 'dashboard' ,
	'caption' => trans('manage::template.dashboard') ,
	'link' => 'dashboard' ,
])


{{--
|--------------------------------------------------------------------------
| Dynamic Ones
|--------------------------------------------------------------------------
|
--}}
@foreach(module('manage')->service('sidebar')->read() as $blade)
	@include($blade['blade'])
@endforeach

{{--
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
| Fixed at the bottom of the menu
--}}
@include('manage::layouts.sidebar-link' , [
	'icon' => "cogs",
	'link' => "jafar",
	'sub_menus' => module('manage')->service('settings_sidebar')->read() ,
	'caption' => trans('manage::settings.title'),
])