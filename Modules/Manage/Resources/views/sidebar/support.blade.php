@if (yasnaSupport()->isNotAvailable())
	@php return @endphp
@endif

@php $submenus = yasnaSupport()->sidebarSubmenus() @endphp

@include("manage::layouts.sidebar-link" , [
	'icon' => "life-ring",
	'caption' => trans("manage::support.title") ,
	'link' => "support" ,
	"sub_menus" => $submenus,
	'permission' => 'super',
	'condition' => !empty($submenus)
])
