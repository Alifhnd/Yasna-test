@include("manage::layouts.sidebar-link" , [
	'icon' => "users",
	'caption' => trans("users::forms.site_users") ,
	'link' => "users" ,
	'sub_menus' => $sub_menus = module('users')->UsersSidebarController()->render() ,
	'permission' => sizeof($sub_menus) ? '' : 'dev',
]     )