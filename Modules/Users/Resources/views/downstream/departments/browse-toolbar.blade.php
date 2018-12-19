@php $title = last($page)[1] @endphp

@include("manage::widgets.toolbar" , [
		'buttons' => [
				[
					'target' => DepartmentsTools::createLink(),
					'type' => "success",
					'caption' => trans('manage::forms.button.add_to')
						. ' '
						. $title,
					'icon' => "plus-circle",
					'condition' => user()->isSuperadmin(),
				],
			],
		]
)
