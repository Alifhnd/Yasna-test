@include('manage::layouts.off-sidebar.theme',[
	'themeName' => user()->adminTheme('theme-a') ,
	"title"=> trans('manage::settings.color_theme'),
	"lightThemes" => [
			[
				"css" => Module::asset("manage:angle/css/theme-a.css"),
				"name" => "theme-a",
				"checked"=> true,
				"color1" => 'bg-info',
				"color2" => 'bg-info-light',
				"bgColor" => 'bg-white'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-b.css"),
				"name" => "theme-b",
				"checked"=> false,
				"color1" => 'bg-green',
				"color2" => 'bg-green-light',
				"bgColor" => 'bg-white'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-c.css"),
				"name" => "theme-c",
				"checked"=> false,
				"color1" => 'bg-purple',
				"color2" => 'bg-purple-light',
				"bgColor" => 'bg-white'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-d.css"),
				"name" => "theme-d",
				"checked"=> false,
				"color1" => 'bg-danger',
				"color2" => 'bg-danger-light',
				"bgColor" => 'bg-white'
			],

	],
	"darkThemes"=>[
			[
				"css" => Module::asset("manage:angle/css/theme-e.css"),
				"name" => "theme-e",
				"checked"=> false,
				"color1" => 'bg-info-dark',
				"color2" => 'bg-info',
				"bgColor" => 'bg-gray-dark'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-f.css"),
				"name" => "theme-f",
				"checked"=> false,
				"color1" => 'bg-green-dark',
				"color2" => 'bg-green',
				"bgColor" => 'bg-gray-dark'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-g.css"),
				"name" => "theme-g",
				"checked"=> false,
				"color1" => 'bg-purple',
				"color2" => 'bg-purple-light',
				"bgColor" => 'bg-gray-dark'
			],
			[
				"css" => Module::asset("manage:angle/css/theme-h.css"),
				"name" => "theme-h",
				"checked"=> false,
				"color1" => 'bg-danger-dark',
				"color2" => 'bg-danger',
				"bgColor" => 'bg-gray-dark'
			]
	]
])
