@include("manage::widgets.toolbar" , [
	'mass_actions' => service('users:mass_actions')->indexed('icon' , 'caption' , 'link') ,
	'buttons' => module('users')->service('browse_buttons')->read() ,
	'search' => [
		'target' => $search_url,
		'label' => trans('manage::forms.button.search'),
		'value' => isset($keyword)? $keyword : ''
	],
])
