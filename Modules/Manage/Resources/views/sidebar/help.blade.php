@include("manage::layouts.sidebar-link" , [
	'icon' => "question-circle",
	'caption' => trans("manage::forms.button.help") ,
	'link' => "help" ,
	"sub_menus" => $sub_menus = service('manage:help_sidebar')->read() ,
	'permission' => sizeof($sub_menus) ? '' : 'dev',
]     )